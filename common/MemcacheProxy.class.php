<?php
/**
 * memcache代理类
 * @author 		杨宇 <yangyu@baidu.com>
 * @package		MemcacheProxy
 */

class MemcacheProxy extends Memcache {
	
	public function connect($host, $port) {

		$ret = false;
		if (!isset($this->mem)){
			$this->mem = new Memcache();
			$ret = $this->mem->connect($host, $port);
		}
		return $ret;
	}

	public function close(){

		if (isset($this->mem)){
			$this->mem->close();
			unset($this->mem);
		}
	}
	
	public function cache_get($cache_config) {

		if (!is_array($cache_config) || $cache_config[2] == false){
			return false;
		}

		$result = $this->mem->get($cache_config[0]);
		return $result;
	}

    public function cache_set($cache_config, $value){

		if (!is_array($cache_config) || $cache_config[2] == false){
			return false;
		}

		$ret = $this->mem->set($cache_config[0], $value, 0, $cache_config[1]);
		if($ret === false) {
			CLogger::warning('set data cache fail', GlobalConfig::BINGO_LOG_ERRNO, array('cachekey' => $cache_config[0]));
		}
		return $ret;
    }

    public function fetch_cache_get($cache_config){

		if (!is_array($cache_config) || $cache_config[2] == false){
			return false;
		}

		$obj = $this->mem->get($cache_config[0]);
		if ($obj !== false) {
			CLogger::debug('fetch return cached results', 0);
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

        $ret = $this->mem->set($cache_config[0], $value, 0, $cache_config[1]);
        if($ret === false) {
           CLogger::warning('fetch set data cache fail', GlobalConfig::BINGO_LOG_ERRNO);
        }
		return $ret;
    }

	public function set($key, $obj, $compressed, $cache_expire_time){
		return  $this->mem->set($key, $obj, $compressed, $cache_expire_time);
	}

	public function get($key){
		return  $this->mem->get($key);
	}


	public function replace($key, $value, $flag = 0, $expire = 0) {
		$ret = $this->mem->replace($key, $value, $flag, $expire);
		return $ret;
	}
	
}
?>