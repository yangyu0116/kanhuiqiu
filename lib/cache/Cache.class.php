<?php 
/**
 * ���洦�����ù���ģʽ���ṩ��5�ִ洢���档
 * ע�⣺�û�����ʺ�������cache������memcache֮��ķֲ�ʽcache����ʱû���ṩ������֧�֡�
 * static : request�����󣩼������ڴ���global�����������ڵĻ��棬�ȽϺ��ʡ�����˵time()��IP��ַ�ȵȡ�
 * apc/eacc: ����cache���ʺ�������С���ݵĵ���cache��
 * file : ����cache���ʺ������������ģ������ٵ�cache������˵output����dict֮��ġ�
 * source :����Դ�뻺�档�Ƚ��ʺ���php��������Ļ��档
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
     * ���õĻ�������
     *
     * @var array
     */
    protected static $_enabledEngine = array('apc','eacc','file','source','static');
    /**
     * Ĭ������
     *
     * @var string
     */
    protected static $_defaultEngine = 'file';
    /**
     * ����ģʽ��factoryһ��cache engine
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
     * ����Ĭ�ϵ�cache engine
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
