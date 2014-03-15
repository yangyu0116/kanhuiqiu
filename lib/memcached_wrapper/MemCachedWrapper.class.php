<?php

class MemCachedWrapper
{
	private $objMemCache = null;	//查询、添加、设置cache时用的memcached实例对象
	private $arrMemCache = null;	//作废cache时用的memcached实例对象数组

	private $errmsg;

	private static $instance = null;

	public static function getInstance()
	{
		if( self::$instance === null )
		{
			self::$instance = new MemCachedWrapper();
		}

		return self::$instance;
	}

	public function __construct()
	{
	}

	public function error()
	{
		return $this->errmsg;
	}

	public function setCompressThreshold($intThreshold, $flMinSavings = 0.2)
	{
		$this->initCurrentMemCache();
		$res = $this->objMemCache->setCompressThreshold($intThreshold, $flMinSavings);
		if( !$res )
		{
			$this->errmsg = 'set compress threshold for memcached failed';
		}
		return $res;
	}

	public function add($strKey, $strValue, $bolFlag = false, $intExpire = 0)
	{
		$this->initCurrentMemCache();
		$res = $this->objMemCache->add($strKey, $strValue, $bolFlag, $intExpire);
		if( !$res )
		{
			$this->errmsg = 'add key(' . $strKey . ') to memcached failed or key has already exists';
		}
		return $res;
	}

	public function get($mixedKey, $mixedFlags = false)
	{ 
		$this->initCurrentMemCache();
		$res = $this->objMemCache->get($mixedKey, $mixedFlags);
		if( $res === false )
		{
			if( is_string($mixedKey) )
			{
				$this->errmsg = 'get key(' . $mixedKey . ') from memcached failed or key not exists';
			}
			else
			{
				$this->errmsg = 'get multiple keys from memcached failed or no keys exists';
			}
		}
		return $res;
	}

	public function set($strKey, $strValue, $bolFlag = false, $intExpire = 0)
	{
		$this->initCurrentMemCache();
		$res = $this->objMemCache->set($strKey, $strValue, $bolFlag, $intExpire);
		if( !$res )
		{
			$this->errmsg = 'set key(' . $strKey . ') to memcached failed';
		}
		return $res;
	}

	public function flush()
	{
		$this->initCurrentMemCache();
		$res = $this->objMemCache->flush();
		if( !$res )
		{
			$this->errmsg = 'flush memcached failed';
		}
		return $res;
	}

	public function flushAll()
	{
		$this->initAllMemCache();
		$this->errmsg = '';
		foreach( $this->arrMemCache as $key => & $objMemCache )
		{
			if( !$objMemCache->flush() )
			{
				$this->errmsg .= $key . ',';
			}
		}
		if( empty($this->errmsg) )
		{
			$this->errmsg = 'success';
			return true;
		}
		else
		{
			$this->errmsg = 'flush memcached for (' . $this->errmsg . ') failed';
			return false;
		}
	}

	public function delete($strKey, $intTimeOut = 0)
	{
		$this->initCurrentMemCache();
		$res = $this->objMemCache->delete($strKey, $intTimeOut);
		if( !$res )
		{
			$this->errmsg = 'delete key(' . $strKey . ') from memcached failed';
		}
		return $res;
	}

	public function deleteAll($strKey, $intTimeOut = 0)
	{
		$this->initAllMemCache();
		$this->errmsg = '';
		foreach( $this->arrMemCache as $key => & $objMemCache )
		{
			if( !$objMemCache->delete($strKey, $intTimeOut) )
			{
				$this->errmsg .= $key . ',';
			}
		}
		if( empty($this->errmsg) )
		{
			$this->errmsg = 'success';
			return true;
		}
		else
		{
			$this->errmsg = 'delete key(' . $strKey . ') from memcached for (' . $this->errmsg . ') failed';
			return false;
		}
	}

	protected function initCurrentMemCache()
	{
		$this->errmsg = 'success';
		if( $this->objMemCache === null )
		{
			$this->objMemCache = new Memcache();

			foreach( LibMemCachedConfig::$arrMemCacheServer[IDCConfig::CURRENT] as $arrServer )
			{
				$this->objMemCache->addServer($arrServer['host'],
											  $arrServer['port'],
											  LibMemCachedConfig::PERSISTENT,
											  $arrServer['weight'],
											  LibMemCachedConfig::TIMEOUT,
											  LibMemCachedConfig::RETRY_INTERVAL,
											  LibMemCachedConfig::INIT_STATUS );
			}
		}
	}

	protected function initAllMemCache()
	{
		if( $this->arrMemCache === null )
		{
			$this->arrMemCache = array();
			foreach( LibMemCachedConfig::$arrMemCacheServer as $key => $arrGroup )
			{
				$objMemCache = new Memcache();
				foreach( $arrGroup as $arrServer )
				{
					$objMemCache->addServer($arrServer['host'],
											$arrServer['port'],
											LibMemCachedConfig::PERSISTENT,
											$arrServer['weight'],
											LibMemCachedConfig::TIMEOUT,
											LibMemCachedConfig::RETRY_INTERVAL,
											LibMemCachedConfig::INIT_STATUS);
				}
				$this->arrMemCache[$key] = $objMemCache;
			}
		}
	}
}

?>
