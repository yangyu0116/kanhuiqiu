<?php
/**
 * config基类
 * @author xuliqiang@baidu.com
 * @since 2009-10-21
 * @package config
 *
 */
abstract class AbstractConfig
{    
	protected $_fileName = '';
	
	protected $_data = array();
	
	protected $_errno = 0;
	
	protected $_errmsg = '';
	
	protected $_enableCache = TRUE;
	
	protected $_cacheEngine = NULL;
	
	protected $_defaultCache = 'static';
	/**
	 * 是否启用自动更新，在原配置文件更新的时候，自动失效cache
	 * 有一定的成本
	 *
	 * @var bool
	 */
	protected $_autoRefresh = FALSE;
	/**
	 * 是否采用序列化
	 *
	 * @var bool
	 */
	protected $_serialize = FALSE;
	
	const FILE_PATH_INVALID = 1;
	
	const INCLUDE_FILE_ERRNO = 2;
	
	const PARSE_INI_ERROR = 3;
	
	const CONFIGURE_EXTENSION_NOT_FOUND = 4;
	
	const CONFIGURE_PARSE_ERROR = 5;
	
	abstract public function setOption($config);
	
	abstract public function load($fileName=NULL);
	
	protected function _cacheLoad($fileName,$callback,$cacheKey=NULL)
	{
	    if (is_null($cacheKey))$cacheKey = $fileName;
	    $cache = $this->getCacheEngine();
	    if ($cache)
	    {
	        //启用了cache
	        $_cacheData = $cache->get($cacheKey);
	        if ($_cacheData)
	        {
	            //命中cache，
	            if ($this->_serialize) $_cacheData = unserialize($_cacheData);
	            if ($this->_autoRefresh)
	            {
	                //启用了自动更新，检查是否需要自动更新
	                $_lastFileTime = filemtime($fileName);
	                if ($_lastFileTime && $_lastFileTime != $_cacheData['lastFileTime'] )
	                {
	                    //需要更新，删除缓存
	                    $cache->remove($cacheKey);
	                }
	                else 
	                {
	                    $this->_data = $_cacheData['data'];        
	                    return $this->_data;       	                
	                }
	            }
	            else 
	            {
	                $this->_data = $_cacheData;	 
	                return $this->_data;                
	            }	      
	        }
	    }
	    if (is_callable($callback))
	    {
	        call_user_func_array($callback,array($fileName));
	    }
	    if ($cache && $this->_data)
	    {
	        //save,是否启用了自动更新，如果是则需要保存文件的最后修改时间
	        if ($this->_autoRefresh)
	        {
	            $_lastFileTime = filemtime($fileName);
	            if (!$_lastFileTime) $_lastFileTime = $this->getNowTime();
	            $_cacheData = array(
	                'lastFileTime'=>$_lastFileTime,
	                'data'=>$this->_data,
	            );
	        }
	        else 
	        {
	            $_cacheData = $this->_data;
	        }
	        if ($this->_serialize) $_cacheData = serialize($_cacheData);
	        $cache->set($cacheKey,$_cacheData);
	    }
	}
	
	protected function _setOption($config)
	{
	    if (isset($config['cache']))
	    {
	        $this->setCacheEngine($config['cache']);
	    } 
	    if (isset($config['autoRefresh']))
	    {
	        $this->setAutoRefresh($config['autoRefresh']);
	    }
	    if (isset($config['serialize']))
	    {
	        $this->setSerialize($config['serialize']);
	    }
	}
	
	public function setAutoRefresh($_autoRefresh)
	{
	    $this->_autoRefresh = (bool)$_autoRefresh;
	}
	
	public function setSerialize($_serialize)
	{
	    $this->_serialize = (bool)$_serialize;
	}
	
    public function get($key,$defaultValue=FALSE)
	{
		if (empty($this->_data) || $this->isError())
		{
			return $defaultValue;
		}
		$keyArray = array_filter(explode('.',$key));
		if (!empty($keyArray))
		{
			$_value = $this->_getItemFromArray($keyArray,$this->_data);
			if ($_value)
			{
				return $_value;
			}
		}
		return $defaultValue;
	}
	/**
	 * TODO
	 *
	 */
	abstract public function save($fileName=NULL); 
	
	public function setCacheEngine($cacheEngine)
	{
	    if (is_subclass_of($cacheEngine,'AbstractCacheEngine'))
	    {
	        $this->_cacheEngine = $cacheEngine;
	        $this->_enableCache = TRUE;
	    }
	}
	
	public function getCacheEngine()
	{
	    if ($this->_enableCache)
	    {
	        if (is_null($this->_cacheEngine))
	        {
	            $this->_cacheEngine = Cache::factory($this->_defaultCache);
	        }
	        return $this->_cacheEngine;
	    }
	    return FALSE;
	}
	
	public function setFileName($fileName)
	{
	    if ($this->isValidFile($fileName))
	    {
	        $this->_fileName = $fileName;
	    }
	}
	
	public function isValidFile($filePath)
	{
		if ( is_file($filePath) && file_exists($filePath) && is_readable($filePath) )
		{
			return TRUE;
		}
		else 
		{
			$this->error(AbstractConfig::FILE_PATH_INVALID,'CONFIG : filepath invalid!filepath['.$filePath.']');
		}
		return FALSE;
	}
	
	protected function _getItemFromArray($keyArray,$array)
	{
		if (is_array($keyArray) && is_array($array) )
		{			
			$_tmpVar = $array;
			foreach ($keyArray as $key)
			{
				if (isset($_tmpVar[$key]))
				{
					$_tmpVar = $_tmpVar[$key];
				}
				else 
				{
					//can not find
					return FALSE;
				}
			}
			return $_tmpVar;
		}
		return FALSE;
	}
	
	public function isError()
	{
		return (boolean)($this->_errno!=0);
	}
	
	public function getErrno()
	{
		return $this->_errno;
	}
	
	public function getErrorMessage()
	{
	    if ($this->_errno!=0)
		{
			return $this->_errmsg;
		}
		return NULL;
	}
	
	public function error($errno,$errmsg)
	{
		$this->_errno = $errno;
		$this->_errmsg = $errmsg;		
	}
	
	public function getData()
	{
		return $this->_data;
	}
    public function getNowTime()
    {
        if (method_exists('Util','getTime'))
        {
            return Util::getTime();
        }
        return time();
    }
}