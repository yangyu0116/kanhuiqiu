<?php 
/**
 * ����class��static�������棬��request���󼶱�Ļ���
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
     * �洢cache������
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