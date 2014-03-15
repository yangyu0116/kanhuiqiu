<?php 
/**
 * PHP文件缓存接口
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
require_once LIB_CACHE_ROOT_PATH . '/engine/AbstractFileCache.class.php';
class SourceFileCache extends AbstractFileCache 
{
    public function __construct( $config = array() )
    {
    	$this->_lifeTime = 0;
    	$this->_cacheFileExtension = '.php';
        $this->setOption($config);
    }
    
    public function setOption($config)
    {
        if (isset($config['dir']))
        {
            $this->setCacheDir($config['dir']);
        }
        if (isset($config['lifeTime']))
        {
        	$this->_lifeTime = intval($config['lifeTime']);
        }
        if (isset($config['encode'])) $this->setFileNameCallback($config['encode']);
    }
    
    public function get($key)
    {
        $fileName = $this->_getFileNameByKey($key);
        if (file_exists($fileName))
        {
            $value = include($fileName);
            if ( is_array($value) && isset($value['head']) && isset($value['data']) )
            {
            	$head = $value['head'];
            	if ( isset($head['need_refresh']) && ( TRUE === $head['need_refresh']) )
            	{
            		//需要进行更新检查
            		if ( $head['refresh_time'] < $this->getNowTime() )
            		{
            			//需要更新
            			if (file_exists($fileName))
            			{
            				@unlink($fileName);
            			}
            			return FALSE;
            		}
            	}
            	return $value['data'];
            }
        }
        return FALSE;
    }
    
    public function set($key,$value,$lifeTime=0)
    {
        $fileName = $this->_getFileNameByKey($key);
		if (empty($lifeTime)) $lifeTime = $this->_lifeTime;
        $value = array(
        	'head'=>$this->_buildHead($lifeTime),
        	'data'=>$value,
        );
        $value = "<?php \r\n return " . var_export($value,true) . ";\r\n ?>";
        return file_put_contents($fileName,$value,LOCK_EX);
    }
    
    public function remove($key)
    {
        $fileName = $this->_getFileNameByKey($key);
        if (file_exists($fileName))
        {
            @unlink($fileName);
        }
    }
        
    protected function _getFileNameByKey($key)
    {
        return $this->_cacheDir . '/' . parent::getEncodeFileName($key) . $this->_cacheFileExtension;
    }    
    
    protected function _buildHead($lifeTime)
    {
    	if ($lifeTime>0)
    	{
    		return array(
    			'need_refresh'=>TRUE,
    			'refresh_time'=>$this->getNowTime()+$lifeTime,
    		);
    	}
    	else 
    	{
    		return array(
    			'need_refresh'=>FALSE,
    		);
    	}
    }
}
