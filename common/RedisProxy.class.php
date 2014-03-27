<?php 
/**
 * @file RedisProxy.class.php
 * @author yangyu(yangyu@baidu.com)
 * @brief redis操作
 **/

class RedisProxy 
{ 
	private $config = array();
    private $REDIS_STATUS = false;   // redis 状态
	private $port = 6379;	//redis默认第一个分片所在端口
	private $idc_current;
	private $write_to_memcache = false;
	private $retry_time = 0;
   
    /* 
     * 构造函数 
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

	//对key进行hash
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
     * 连接redis，执行连接 
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
			//判断redis是否挂掉
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
     * 获取hash处理后的key 
     * $this->redis redis连接对象 
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
     * 获取字符串对象 
     * $this->redis redis连接对象 
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
     * 设置字符串，带生存时间 
     * $this->redis redis连接对象 
    */
    public function set($key, $value, $compressed = false, $time = 300){

		if (($this->redis = $this->connect($key, 'master')) === false){
			return false;
		}

		//set到memcache
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
     * 批量删除key 
     * $this->redis redis连接对象 
    */
    public function batch_del_key($key_pre){ 
        return $this->redis->delete($key); 
    } 
   
    /* 
     * 判断key是否存在 
     * $this->redis redis连接对象 
    */
    public function key_exists($key){ 
        return $this->redis->exists($key); 
    } 
   
    /* 
     * 判断key剩余有效时间，单位秒 
     * $this->redis redis连接对象 
    */
    public function get_ttl($key){
        return $this->redis->ttl($key); 
    } 
   

    /* 
     * 设置锁 
     * $this->redis redis连接对象 
     * $str， 字符串 
    */
    public function set_lock($key,$value){ 
        return $this->redis->setnx($key,$value); 
    } 
   
    /* 
     * 删除key 
     * $this->redis redis连接对象 
    */
    public function delete_key($key){ 
        return $this->redis->delete($key); 
    } 
   
    /* 
     * 链表增加多个元素 
     * $this->redis redis连接对象 
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
     * 链表弹出多个元素 
     * $this->redis redis连接对象 
     * 返回数组 
    */
    public function list_pop_element($key,$num=1,$direction='right') { 
        for($i=0;$i<$num;$i++){ 
           $value = ($direction == 'right') ? $this->redis->rPop($key) : $this->redis->lPop($key); 
           $data[]=json_decode($value); 
        } 
        return $data; 
    } 
   
    /* 
     * 哈希表新增或修改元素 
     * $this->redis redis连接对象 
     * $array 关联数组 
    */
    public function hash_set($hash_key, $key, $value, $time = 300){ 
           $this->redis->hset($hash_key, $key, $value);
		   $this->redis->expire($hash_key, $time);
    } 
   
    /* 
     * 哈希表读取元素 
     * $this->redis redis连接对象 
    */
    public function hash_get($hash_key, $key){ 
           return $this->redis_slave->hget($hash_key, $key);
    } 
   
    /* 
     * 哈希表元素加减法 
     * $this->redis redis连接对象 
     * 给哈希键为key的field字段加上数字value，value为负数，就是减法 
    */
    public function hash_compute($key,$field,$value=1){ 
        return $this->redis->hIncrBy($key,$field,$value); 
    } 
   
    /* 
     * 哈希表判断某字段是否存在 
     * $this->redis redis连接对象 
    */
    public function hash_exists($key,$field){ 
        return $this->redis->exists($key,$field); 
    } 
   
    /* 
     * 哈希表删除某字段 
     * $this->redis redis连接对象 
    */
    public function hash_delete($key,$field){ 
        return $this->redis->del($key,$field); 
    } 
   
    /* 
     * 获取哈希表所有字段以及值 
     * $this->redis redis连接对象 
    */
    public function hash_getall($key){ 
        return $this->redis_slave->getall($key); 
    } 
   
    /* 
     * 自加一，默认加一 
     * $this->redis redis连接对象 
    */
    public function incr($key,$value=1){ 
   
        $this->redis->incr($key,$value); 
   
    } 
   
    /* 
     * 自减一，默认减一 
     * $this->redis redis连接对象 
    */
    public function decr($key,$value=1){ 
   
        $this->redis->decr($key,$value); 
   
    } 
   
    /* 
     * 清空当前db 
     * $this->redis redis连接对象 
    */
    public function clean(){ 
   
        $this->redis->flushdb(); 
   
    } 
   
} 
   
