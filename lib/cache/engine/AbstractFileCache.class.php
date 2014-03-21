<?php
/**
 * 文件类缓存接口
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
abstract class AbstractFileCache extends AbstractCacheEngine  
{
	/**
     * 缓存目录
     *
     * @var string
     */
    protected $_cacheDir = './';
    /**
     * 有效时长，0表示永远不失效
     *
     * @var int
     */
    protected $_lifeTime = '900';//15 min   
    /**
     * 缓存文件后缀
     *
     * @var string
     */
    protected $_cacheFileExtension = '.php';
    /**
     * 文件名加密的函数
     *
     * @var callback
     */
    protected $_encodeFileNameCallback = 'rawurlencode';

    /**
     * 设置文件名的callback
     *
     * @param callback $callback
     */
    public function setFileNameCallback($callback)
    {
    	if ( is_callable($callback) )
    	{
    		$this->_encodeFileNameCallback = $callback;
    	}
    }
    /**
     * 获取合法的文件名
     *
     * @param string $key
     * @return string
     */
    public function getEncodeFileName($key)
    {
    	return call_user_func_array($this->_encodeFileNameCallback,array($key));
    }
    /**
     * 设置缓存目录
     *
     * @param unknown_type $dir
     */
	public function setCacheDir($dir)
    {
        if ( is_dir($dir) && file_exists($dir) && is_writable($dir))
        {
            $this->_cacheDir = rtrim($dir,'/');
        }
        else 
        {
            parent::_error(parent::CACHE_DIR_INVALD);
//            throw new Exception('setCacheDir:' . $dir . ' is invalid!');
        }
    }
}
