<?php
/**
 * apc»º´æ½Ó¿Ú
 * @author xuliqiang@baidu.com
 * @since 2009-10-17
 * @package cache
 *
 */
if (!defined('LIB_CACHE_ROOT_PATH'))
{
    define('LIB_CACHE_ROOT_PATH',dirname(__FILE__).'/..');
}
require_once LIB_CACHE_ROOT_PATH . '/AbstractCacheEngine.class.php';
class ApcCache extends AbstractCacheEngine 
{
	protected $_lifeTime = 900;
	
	public function __construct($config=array())
	{
		if (!extension_loaded('apc'))
		{
			parent::_error(parent::APC_NOT_FOUND);
			throw new Exception('The apc extension must be loaded for using ApcCache !');
		}
		$this->setOption($config);
	}
	
	public function get($key)
	{
		return apc_fetch($key);
	}
    
    public function set($key,$value,$lifeTime=NULL)
    {
    	if (is_null($lifeTime)) $lifeTime = $this->_lifeTime;
    	return apc_store($key, $value, $lifeTime);
    }
    
    public function remove($key)
    {
    	return apc_delete($key);
    }
    
    public function setOption($config)
    {
    	if (isset($config['lifeTime'])) $this->_lifeTime = intval($config['lifeTime']);
    }
}