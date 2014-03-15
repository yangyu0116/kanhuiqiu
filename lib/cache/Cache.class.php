<?php 
/**
 * 缓存处理，采用工厂模式，提供了5种存储引擎。
 * 注意：该缓存库适合做单机cache。对于memcache之类的分布式cache，暂时没有提供引擎来支持。
 * static : request（请求）级别。用于处理global变量和请求内的缓存，比较合适。比如说time()，IP地址等等。
 * apc/eacc: 单机cache。适合做大量小数据的单机cache。
 * file : 单机cache。适合做大数据量的，更新少的cache，比如说output或者dict之类的。
 * source :采用源码缓存。比较适合做php数组变量的缓存。
 * 
 * @author xuliqiang@baidu.com
 * @since 2009-10-20
 * @package cache
 *
 */
if (!defined('LIB_CACHE_ROOT_PATH'))
{
    define('LIB_CACHE_ROOT_PATH',dirname(__FILE__));
}
require_once LIB_CACHE_ROOT_PATH . '/AbstractCacheEngine.class.php';
class Cache
{
    /**
     * 启用的缓存引擎
     *
     * @var array
     */
    protected static $_enabledEngine = array('apc','eacc','file','source','static');
    /**
     * 默认引擎
     *
     * @var string
     */
    protected static $_defaultEngine = 'file';
    /**
     * 工厂模式，factory一个cache engine
     *
     * @param string $engine
     * @param array $options
     * @return AbstractCacheEngine
     */
    public static function factory($engine,$options=array())
    {
        $engine = strtolower($engine);
        if (!in_array($engine,self::$_enabledEngine))
        {
            $engine = self::$_defaultEngine;
        }
        switch ($engine)
        {
            case 'apc':
                require_once LIB_CACHE_ROOT_PATH .'/engine/ApcCache.class.php';
                $engine = new ApcCache($options);
                break;
            case 'eacc':
                require_once LIB_CACHE_ROOT_PATH .'/engine/EaccCache.class.php';
                $engine = new EaccCache($options);
                break;            
            case 'source':
                require_once LIB_CACHE_ROOT_PATH .'/engine/SourceFileCache.class.php';
                $engine = new SourceFileCache($options);
                break;
            case 'static':
                require_once LIB_CACHE_ROOT_PATH .'/engine/StaticCache.class.php';
                $engine = new StaticCache($options);
                break;
            case 'file':
            default:
                require_once LIB_CACHE_ROOT_PATH .'/engine/FileCache.class.php';
                $engine = new FileCache($options);
                break;
        }
        return $engine;
    }
    /**
     * 设置默认的cache engine
     *
     * @param string $engine
     */
    public static function setDefaultEngine($engine)
    {
        if (in_array($engine,self::$_enabledEngine))
        {
            self::$_defaultEngine = $engine;
        }
        return TRUE;
    }
}
