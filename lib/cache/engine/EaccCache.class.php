<?php
/**
 * eacclerator»º´æ½Ó¿Ú
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
class EaccCache extends AbstractCacheEngine 
{
	protected $_lifeTime = 900;
	
	public function __construct($config=array())
	{
		if (!extension_loaded('eaccelerator'))
		{
			parent::_error(parent::EACC_NOT_FOUND);
			throw new Exception('The eaccelerator extension must be loaded for using EaccCache !');
		}
		$this->setOption($config);
	}
	
	public function get($key)
	{
		return eaccelerator_get($key);
	}
    
    public function set($key,$value,$lifeTime=NULL)
    {
    	if (is_null($lifeTime)) $lifeTime = $this->_lifeTime;
    	return eaccelerator_put($key, $value, $lifeTime);
    }
    
    public function remove($key)
    {
    	return eaccelerator_rm($key);
    }
    
    public function setOption($config)
    {
    	if (isset($config['lifeTime'])) $this->_lifeTime = intval($config['lifeTime']);
    }
}