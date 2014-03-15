<?php


class CommonCache
{
	private $objMemCache = null;	//查询、添加、设置cache时用的memcached实例对象
	private $arrMemCache = null;	//作废cache时用的memcached实例对象数组

    private $app_key = null;

	private $errmsg;

	private static $instance = null;
	// zcache 宕机标志位
	private static $zcache_down = false;
	// zcache 繁忙标志位
	private static $zcache_busy = false;
	// zcache 分流比例
	private static $zcache_busy_percent = 100;
	private $ZCACHE_MOD = 20;
	public static function getInstance($app_key=null)
	{
		if( self::$instance === null )
		{
			self::$instance = new CommonCache($app_key);
		}

		return self::$instance;
	}

	public function __construct($app_key=null)
	{
        $this->initCurrentCache();
        $this->app_key=$app_key;
	}
        
	public function error()
	{
		return $this->errmsg;
	}

	public function setCompressThreshold($intThreshold, $flMinSavings = 0.2)
	{

	}

	public function add($strKey, $strValue, $intExpire = 0, $isHash = false)
	{   
		return false;	//关闭zcache
		/*if ($this->checkZcacheDown()) {
			// check if zcache down
			return null;
		}*/
		$strValue =  serialize($strValue);
		$app_key = $this->app_key;
		if(true === $isHash)
			$app_key = $this->getHashedKey($strKey);
        if($app_key){
            $res = $this->objMemCache->addOne($app_key,$strKey, $strValue, $intExpire);
        }else{
            $res = $this->objMemCache->addOne($strKey, null, $strValue, $intExpire);
        }
		
		if( !empty($res) )
		{
			$this->errmsg = 'add key(' . $strKey . ') to memcached failed or key has already exists,err no:'.$res;
		}
		return $res;
	}

	public function get($mixedKey, $isHash = false)
	{
		return false;	//关闭zcache
		/*if ($this->checkZcacheDown()) {
			// check if zcache down
			return null;
		}*/
		
        if(is_array($mixedKey)){
            $res = array();
            foreach($mixedKey as $key){
                $res[] = $this->getOne($key, $isHash);
            }
        }else{
		    $res = $this->getOne($mixedKey, $isHash);
        }
		return $res;
	}

    public function getOne($key, $isHash = false)
	{
		/*if ($this->checkZcacheDown()) {
			// check if zcache down
			return null;
		}*/
		
		$app_key = $this->app_key;
		if(true === $isHash)
			$app_key = $this->getHashedKey($key);
        if($app_key){
            $res = $this->objMemCache->getOne($app_key,$key);
        }else{
            $res = $this->objMemCache->getOne($key,null);
        }
		if( $res === null )
		{
			if( is_string($key) )
			{
				$this->errmsg = 'get key(' . $key . ') from memcached failed or key not exists';
			}
			$last_err = $this->objMemCache->getLastErr();
			if ($last_err != 'ZCACHE_OK' && $last_err != 'ZCACHE_ERR_NOT_EXIST' && $last_err != 'ZCACHE_ERR_BLOCK_NOT_EXIST') {
				// zcache 宕机，设置标志位
				CLogger::warning('Zcache error: '. $last_err);
        	}
        }
		
		if(null === $res)
			return null;
		return unserialize($res);
	}
	public function getMultiple($key, $isHash = false)
	{
		if ($this->checkZcacheDown()) {
			// check if zcache down
			return null;
		}
		$total = count($key);
		$everyCnt = GlobalConfig::$zcacheConf['MUTIPLE_KEYS_COUNT_EVERY_CONNECTION'];
		if($total <= $everyCnt){
			return $this->old_getMultiple($key,$isHash);
		}
		$ret = array();
		$all_fail = true;
		for($i=0;$i<$total;$i+=$everyCnt){
			$s_key = array_slice($key,$i,$everyCnt);
			$s_cnt = count($s_key);
			$s_items = $this->old_getMultiple($s_key,$isHash);
			if($s_items === null){
				$s_substitute = array_fill(0,$s_cnt,'');
				$ret = array_merge($ret,$s_substitute);
				unset($s_key);
				unset($s_substitute);
			}else{
				$all_fail = false;
				$ret = array_merge($ret,$s_items);
			}
			unset($s_items);
		}
		if($all_fail){
			return null;
		}else{
			return $ret;
		}
	}
	//返回null 或array();
    public function old_getMultiple($key, $isHash = false)
	{
		if ($this->checkZcacheDown()) {
			// check if zcache down
			return null;
		}
		if (self::$zcache_down) {
			// zcache 宕机，或者zcache繁忙时取得随机数小于$zcache_busy_percent, 直接返回null，避免每个请求50ms的耗时
			return null;
		}

		if(true === $isHash){
			foreach($key as &$v){
				$v['key'] = $this->getHashedKey($v['subkey'], $v['key']);
			}
		}
        $res = $this->objMemCache->getMultiple($key);
		if( $res === null )
		{
			$last_err = $this->objMemCache->getLastErr();
			if ($last_err != 'ZCACHE_OK' && $last_err != 'ZCACHE_ERR_NOT_EXIST' && $last_err != 'ZCACHE_ERR_BLOCK_NOT_EXIST') {
				// zcache 宕机，设置标志位
				CLogger::warning('Zcache error: '. $last_err);
        	}
        }
		
		return $res;
	}

    

	public function set($strKey, $strValue, $intExpire = 0, $isHash = false)
	{
		return false;	//关闭zcache
		/*if ($this->checkZcacheDown()) {
			// check if zcache down
			return null;
		}*/
		
		$strValue =  serialize($strValue);
		$app_key = $this->app_key;
		if(true === $isHash)
			$app_key = $this->getHashedKey($strKey);
        if($app_key){
            $res = $this->objMemCache->updateOne($app_key,$strKey, $strValue,$intExpire);
        }else{
            $res = $this->objMemCache->updateOne($strKey,null, $strValue,$intExpire);
        }
		if( !$res )
		{
			$this->errmsg = 'set key(' . $strKey . ') to memcached failed';
		}
		return $res;
	}

	public function flush()
	{
		
	}

	public function delete($strKey, $intTimeOut = 0, $isHash = false)
	{
		if ($this->checkZcacheDown()) {
			// check if zcache down
			return null;
		}
		$app_key = $this->app_key;
		if(true === $isHash)
			$app_key = $this->getHashedKey($strKey);
        if($app_key){
            $res = $this->objMemCache->deleteOne($app_key, $strKey,$intTimeOut);
        }else{
            $res = $this->objMemCache->deleteOne($strKey, null,$intTimeOut);
        }
		
		if( !$res )
		{
			$this->errmsg = 'delete key(' . $strKey . ') from memcached failed';
		}
		return $res;
	}

	protected function initCurrentCache()
	{
		$this->errmsg = 'success';
		if( $this->objMemCache === null )
		{
			$this->objMemCache = new CZcacheAdapter(ZcacheConf::$arrconfig);
		}
	}

	protected function initAllCache()
	{
		
	}
	
	public function getLastErr(){
		return $this->objMemCache->getLastErr();
	}
	
	public function isSuccess(){
		return 'ZCACHE_OK' == $this->objMemCache->getLastErr();
	}
	
	private function getHashedKey($subKey, $original_key = ''){
		$app_key = hexdec(substr(md5($subKey), 0, 7));
		$original_key = $original_key ? $original_key : $this->app_key;
        /*if(GlobalConfig::$isTest && GlobalConfig::$testing){
                $original_key .= GlobalConfig::$testZcacheKey;
        }*/
		return $original_key . CACHEKEYSEPARATOR . ($app_key % $this->ZCACHE_MOD);
	}
	
	private function checkZcacheDown() {
		if (self::$zcache_down) {
			// zcache 宕机，或者zcache繁忙时取得随机数小于$zcache_busy_percent, 直接返回null，避免每个请求50ms的耗时
			CLogger::warning('Zcache down, skip zcache socket, get data from DB!');
			return true;
		}
		return false;
	}
	
}

?>
