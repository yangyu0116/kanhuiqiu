<?php 
/**
 * 采用class的static来做缓存，是request请求级别的缓存
 * @author xuliqiang@baidu.com
 * @since 2009-10-20
 * @package cache
 *
 */
if (!defined('LIB_CACHE_ROOT_PATH'))
{
    define('LIB_CACHE_ROOT_PATH',dirname(__FILE__).'/..');
}
require_once LIB_CACHE_ROOT_PATH . '/AbstractCacheEngine.class.php';
class StaticCache extends AbstractCacheEngine 
{
    /**
     * 存储cache的数组
     *
     * @var unknown_type
     */
    protected static $_cache = array();
    
    public function get($key)
    {
        if (isset(self::$_cache[$key]))
        {
            return self::$_cache[$key];        
        }
        return FALSE;
    }
    
    public function set($key,$value,$lifeTime=NULL)
    {
        self::$_cache[$key] = $value;
        return TRUE;
    }
    
    public function remove($key)
    {
        if (isset(self::$_cache[$key]))
        {
            self::$_cache[$key] = NULL;
            unset(self::$_cache[$key]);        
        }
        return TRUE;
    }
    
    public function setOption($config)
    {
        
    }
}