<?php 
/**
 * @file RedisProxy.class.php
 * @author yangyu(yangyu@baidu.com)
 * @brief redis����
 **/

class RedisProxy 
{ 
	private $config = array();
    private $REDIS_STATUS = false;   // redis ״̬
	private $port = 6379;	//redisĬ�ϵ�һ����Ƭ���ڶ˿�
	private $idc_current;
	private $write_to_memcache = false;
	private $retry_time = 0;
   
    /* 
     * ���캯�� 
    */
    public function __construct(){
		
		if ($this->REDIS_STATUS === false){
			$this->redis = false;
			return false;
		}

		$this->idc_current = IDCConfig::CURRENT;
		$this->config = BNSConfig::$RedisBNSConf;
		foreach ($this->config['slave'][$this->idc_current] as &$config){
			$config['ip'] = '127.0.0.1';
		}
    }

	public function cache_get($cache_config) {

		if (!is_array($cache_config) || $cache_config[2] == false){
			return false;
		}

		$result = $this->get($cache_config[0]);
		return $result;
	}

    public function cache_set($cache_config, $value){
		
		if (!is_array($cache_config) || $cache_config[2] == false){
			return false;
		}

		$ret = $this->set($cache_config[0], $value, 0, $cache_config[1]);
		if($ret === false) {
			CLogger::warning('set data cache fail', GlobalConfig::BINGO_LOG_ERRNO, array('cachekey' => $cache_config[0]));
		}
		return $ret;
    }

    public function fetch_cache_get($cache_config){
		
		if (!is_array($cache_config) || $cache_config[2] == false){
			return false;
		}

		$obj = $this->get($cache_config[0]);

		if ($obj !== false) {
			return $obj;
		}
		else {
			CLogger::debug('no results in cache', 0);
			return false;
		}
    }

    public function fetch_cache_set($cache_config, $value){
		
		if (!is_array($cache_config) || $cache_config[2] == false){
			return false;
		}

        $ret = $this->set($cache_config[0], $value, false, $cache_config[1]);
        if($ret === false) {
           CLogger::warning('fetch set data cache fail', GlobalConfig::BINGO_LOG_ERRNO);
        }
		return $ret;
    }

	//��key����hash
	private function key_hash($key, $config_keys = array()){

		$md5 = md5($key);
		if (empty($config_keys)){
			$num = hexdec(substr($md5, -1));
		}else{
			//$num = hexdec(substr($md5,-2)) % $mod;
			$rand_key = array_rand($config_keys);
			$num = $config_keys[$rand_key];
		}
		return $num;
	}
   

    /* 
     * ����redis��ִ������ 
    */
    public function connect($key, $role = 'master'){
		
		if ($this->REDIS_STATUS === false){
			return false;
		}
        
		if ($role == 'master'){
			$config = $this->config[$role];
			$idc = current($config);
		}else{
			$config = $this->config[$role][$this->idc_current];
			$config_key = $this->key_hash($key, array_keys($config));
			$idc = $config[$config_key];
		}

		//$port = $this->port + $this->key_hash($key);	//(9980 - 9995)
		$port = 6379;

        try {
			$redis = new Redis(); 
            $redis->connect($idc['ip'], $port);
        } catch (Exception $e) { 
            $redis = false; 
        }

		if ($role == 'slave'){
			//�ж�redis�Ƿ�ҵ�
			if (!isset($redis->socket)){
				if ($this->retry_time < 3){
					CLogger::warning('redis down!', GlobalConfig::BINGO_LOG_ERRNO, array('idc' => $idc['host']));
					unset($this->config['slave'][$this->idc_current][$config_key]);
					$this->retry_time += 1;
					return $this->connect($key, 'slave');
				}else{
					$this->REDIS_STATUS = false;
					return false;
				}
			}
		}

        return $redis; 
    }
	
    /* 
     * ��ȡhash������key 
     * $this->redis redis���Ӷ��� 
     */
    public function get_hash_key($key){
		if (!strstr($key, '::')){
			$hash_key = substr($key, 0, strpos($key, '.')).'::'.substr($key, strpos($key, '.')+1);
		}else{
			$hash_key = $key;
		}
        return $hash_key; 
    }

    /* 
     * ��ȡ�ַ������� 
     * $this->redis redis���Ӷ��� 
    */
    public function get($key){
		
		if (($this->redis_slave = $this->connect($key, 'slave')) === false){
			return false;
		}

		if (strstr($key, '.') === false){
			$res = unserialize($this->redis_slave->get($key));
		}else{
			$hash_key = $this->get_hash_key($key);
			//$res = unserialize($this->hash_get($hash_key, $key)); 
			$res = unserialize($this->redis_slave->get($hash_key));
		}
		return $res;
    } 
   
    /* 
     * �����ַ�����������ʱ�� 
     * $this->redis redis���Ӷ��� 
    */
    public function set($key, $value, $compressed = false, $time = 300){

		if (($this->redis = $this->connect($key, 'master')) === false){
			return false;
		}

		//set��memcache
		if ($this->write_to_memcache == true){
			$memcache = new Memcache();
			$memcache->connect('127.0.0.1', 11211);
			$ret = $memcache->set($key, $value, false, $time);
			if($ret === false) {
				 CLogger::warning('memcache set data cache fail', GlobalConfig::BINGO_LOG_ERRNO, array('cachekey' => $key));
			}
		}


        $str = serialize($value); 
		
		//single key or hash key
		if (strstr($key, '.') === false){
			if ($time == 0){
				$this->redis->set($key, $str); 
			} else{ 
				$this->redis->setex($key, $time, $str); 
			} 
		}else{
			$hash_key = $this->get_hash_key($key);
			$this->redis->setex($hash_key, $time, $str); 
			//$this->hash_set($hash_key, $key, $str, $time); 
		}
	
    } 
   


    /* 
     * ����ɾ��key 
     * $this->redis redis���Ӷ��� 
    */
    public function batch_del_key($key_pre){ 
        return $this->redis->delete($key); 
    } 
   
    /* 
     * �ж�key�Ƿ���� 
     * $this->redis redis���Ӷ��� 
    */
    public function key_exists($key){ 
        return $this->redis->exists($key); 
    } 
   
    /* 
     * �ж�keyʣ����Чʱ�䣬��λ�� 
     * $this->redis redis���Ӷ��� 
    */
    public function get_ttl($key){
        return $this->redis->ttl($key); 
    } 
   

    /* 
     * ������ 
     * $this->redis redis���Ӷ��� 
     * $str�� �ַ��� 
    */
    public function set_lock($key,$value){ 
        return $this->redis->setnx($key,$value); 
    } 
   
    /* 
     * ɾ��key 
     * $this->redis redis���Ӷ��� 
    */
    public function delete_key($key){ 
        return $this->redis->delete($key); 
    } 
   
    /* 
     * �������Ӷ��Ԫ�� 
     * $this->redis redis���Ӷ��� 
    */
    public function list_add_element($key,$array,$direction='left'){ 
        if(!is_array($array)){ 
            $array=array($array); 
        } 
        foreach($array as $val){ 
            ($direction == 'left') ? $this->redis->lPush($key, json_encode($val)) : $this->redis->rPush($key, json_encode($val)); 
        } 
    } 
   
    /* 
     * ���������Ԫ�� 
     * $this->redis redis���Ӷ��� 
     * �������� 
    */
    public function list_pop_element($key,$num=1,$direction='right') { 
        for($i=0;$i<$num;$i++){ 
           $value = ($direction == 'right') ? $this->redis->rPop($key) : $this->redis->lPop($key); 
           $data[]=json_decode($value); 
        } 
        return $data; 
    } 
   
    /* 
     * ��ϣ���������޸�Ԫ�� 
     * $this->redis redis���Ӷ��� 
     * $array �������� 
    */
    public function hash_set($hash_key, $key, $value, $time = 300){ 
           $this->redis->hset($hash_key, $key, $value);
		   $this->redis->expire($hash_key, $time);
    } 
   
    /* 
     * ��ϣ���ȡԪ�� 
     * $this->redis redis���Ӷ��� 
    */
    public function hash_get($hash_key, $key){ 
           return $this->redis_slave->hget($hash_key, $key);
    } 
   
    /* 
     * ��ϣ��Ԫ�ؼӼ��� 
     * $this->redis redis���Ӷ��� 
     * ����ϣ��Ϊkey��field�ֶμ�������value��valueΪ���������Ǽ��� 
    */
    public function hash_compute($key,$field,$value=1){ 
        return $this->redis->hIncrBy($key,$field,$value); 
    } 
   
    /* 
     * ��ϣ���ж�ĳ�ֶ��Ƿ���� 
     * $this->redis redis���Ӷ��� 
    */
    public function hash_exists($key,$field){ 
        return $this->redis->exists($key,$field); 
    } 
   
    /* 
     * ��ϣ��ɾ��ĳ�ֶ� 
     * $this->redis redis���Ӷ��� 
    */
    public function hash_delete($key,$field){ 
        return $this->redis->del($key,$field); 
    } 
   
    /* 
     * ��ȡ��ϣ�������ֶ��Լ�ֵ 
     * $this->redis redis���Ӷ��� 
    */
    public function hash_getall($key){ 
        return $this->redis_slave->getall($key); 
    } 
   
    /* 
     * �Լ�һ��Ĭ�ϼ�һ 
     * $this->redis redis���Ӷ��� 
    */
    public function incr($key,$value=1){ 
   
        $this->redis->incr($key,$value); 
   
    } 
   
    /* 
     * �Լ�һ��Ĭ�ϼ�һ 
     * $this->redis redis���Ӷ��� 
    */
    public function decr($key,$value=1){ 
   
        $this->redis->decr($key,$value); 
   
    } 
   
    /* 
     * ��յ�ǰdb 
     * $this->redis redis���Ӷ��� 
    */
    public function clean(){ 
   
        $this->redis->flushdb(); 
   
    } 
   
} 
   
