<?php
/**
 * �ļ��໺��ӿ�
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
     * ����Ŀ¼
     *
     * @var string
     */
    protected $_cacheDir = './';
    /**
     * ��Чʱ����0��ʾ��Զ��ʧЧ
     *
     * @var int
     */
    protected $_lifeTime = '900';//15 min   
    /**
     * �����ļ���׺
     *
     * @var string
     */
    protected $_cacheFileExtension = '.php';
    /**
     * �ļ������ܵĺ���
     *
     * @var callback
     */
    protected $_encodeFileNameCallback = 'rawurlencode';

    /**
     * �����ļ�����callback
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
     * ��ȡ�Ϸ����ļ���
     *
     * @param string $key
     * @return string
     */
    public function getEncodeFileName($key)
    {
    	return call_user_func_array($this->_encodeFileNameCallback,array($key));
    }
    /**
     * ���û���Ŀ¼
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
