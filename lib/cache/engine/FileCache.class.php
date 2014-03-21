<?php 
/**
 * 文件缓存
 * @author xuliqiang@baidu.com
 * @since 2009-10-14
 *
 */
if (!defined('LIB_CACHE_ROOT_PATH'))
{
    define('LIB_CACHE_ROOT_PATH',dirname(__FILE__).'/..');
}
require_once LIB_CACHE_ROOT_PATH . '/AbstractCacheEngine.class.php';
require_once LIB_CACHE_ROOT_PATH . '/engine/AbstractFileCache.class.php';
class FileCache extends AbstractFileCache 
{
    /**
     * 是否调用serialize方式序列化内容
     *
     * @var bool
     */
    protected $_serialize = FALSE;
    /**
     * 缓存文件夹层数
     *
     * @var int
     */
    protected $_filePathLevel = 0;
    /**
     * 内容校验回调函数
     *
     * @var unknown_type
     */
    protected $_validatorCallback = FALSE;
    
    protected $_encodeHead = FALSE;
    
    protected $_staticHeadLen = 64;
    
    protected $_headLen = 128;
    
    public function __construct($config=array())
    {
    	$this->_lifeTime = 900;
    	$this->_cacheFileExtension = '.cache';
        $this->setOption($config);
    }
        
    public function get($key)
    {
        $fileName = $this->_getFileNameByKey($key);        
        if (file_exists($fileName) && is_readable($fileName) )
        { 
            //
            $_fileLen = filesize($fileName);
            
            if ( $_fileLen > $this->_headLen)
            {
            	$fp = fopen($fileName,'rb');
            	if (!$fp) return FALSE;
            	flock($fp,LOCK_SH);
            	
            	//读取头
            	$head = fread($fp,$this->_headLen);     
            	if (!$head)
            	{
            		flock($fp,LOCK_UN);
            		fclose($fp);
            		return FALSE;       	
            	}
            	$staticHead = substr($head,0,$this->_staticHeadLen);
            	list($_lifeTime,$_serialize,$_validator) = explode(':',$staticHead);
            	if ( $_lifeTime>0 && $this->getNowTime()>$_lifeTime )
            	{
            		//过期
            		flock($fp,LOCK_UN);
            		fclose($fp);
            		@unlink($fileName);
            	}
            	else 
            	{
            		//没有过期
            		$data = fread($fp,$_fileLen-$this->_headLen);
            		flock($fp,LOCK_UN);
            		fclose($fp);
            		if (!$data)
            		{            			
            			return FALSE;  
            		}
            		if ( $_validator!= 0 )
            		{
            			//TODO校验数据是否正确
            		}
            		if ( $_serialize )
            		{
            			//需要反序列化
            			if($_boolRs = unserialize($data))
            			{
            				$data = $_boolRs;
            			}
            		}
            		return $data;
            	}
            }
            else 
            {
            	//文件长度不对
            	@unlink($fileName);
            }
        }
        return FALSE;        
    }
    
    public function set($key,$value,$lifeTime=NULL)
    {
        $fileName = $this->_getFileNameByKey($key);        
        if ( FALSE == $fileName) return FALSE;
        if (is_null($lifeTime))$lifeTime = $this->_lifeTime;
        /**
         * 序列化
         */
        $_serialize = $this->_serialize;
        if ($_serialize) 
        {
            $value = serialize($value);
        }       
        else 
        {
        	if ( !is_scalar($value) )
        	{
            	//非标量需要强制序列化
            	$value = serialize($value);
            	$_serialize = TRUE;
        	} 
        }        
        //产生文件头信息
        $_validatorStr = '';
        if ( is_callable($this->_validatorCallback) )
        {
        	$_validatorStr = call_user_func_array($this->_validatorCallback,$value);
        }
        $head = $this->_buildHead($lifeTime,$_serialize,$this->_validatorCallback,$_validatorStr);
        //写入数据
        return file_put_contents($fileName,$head . $value,LOCK_EX);
    }
    
    public function remove($key)
    {
        $fileName = $this->_getFileNameByKey($key);
        if ( file_exists($fileName) )
        {
            @unlink($fileName);
        }
        return TRUE;
    }
	public function setOption($config)
    {
        if (isset($config['level'])) $this->_filePathLevel = intval($config['level']);
        if (isset($config['dir']))
        {
            $this->setCacheDir($config['dir']);
        }
        if (isset($config['lifeTime'])) $this->_lifeTime = intval($config['lifeTime']);
        if (isset($config['serialize'])) $this->_serialize = (bool)$config['serialize'];
        if (isset($config['encode_head'])) $this->_encodeHead = (bool)$config['encode_head'];
        if (isset($config['validator'])) $this->setValidator($config['validator']);
        if (isset($config['encode'])) $this->setFileNameCallback($config['encode']);
    }
	/**
     * 设置内容校验的回调函数
     *
     * @param callback $callback
     */
    public function setValidator( $callback )
    {
    	if ( is_callable($callback) )
    	{
    		$this->_validatorCallback = $callback;
    	}
    }
    
    protected function _buildHead($lifeTime,$serialize,$valiator,$validatorStr)
    {
    	if ( TRUE === $this->_encodeHead)
    	{
    		//TODO
    		$head = '';
    	}
    	else
    	{
    		if ( $lifeTime ==0 )
    		{
    			$head = '0';
    		}
    		else 
    		{
    			$head = $this->getNowTime() + $lifeTime;
    		}
    		$head .= ':' . intval($serialize) . ':';
    		if ( FALSE == $valiator)
    		{
    			$head .= '0:';
    		}
    		else 
    		{
    			$head .= $valiator .':';
    		}
    		$head = str_pad($head,$this->_staticHeadLen);
    		//附加上加密串
    		$head = str_pad($head . $validatorStr,$this->_headLen);
    	}
    	return $head;
    }
            
    protected function _getFileNameByKey($key)
    {
        if (parent::isError())return FALSE;
        $str = md5($key);
        $_level = $this->_filePathLevel;
        $path = $this->_cacheDir . '/';
        if ($_level>0)
        {            
            for ($i=0;$i<$_level;$i++)
            {
                $path .= substr($str,$i*2,2) .'/';
                if ( !is_dir($path) || !file_exists($path) )
                {
                    //mkdir
                    @mkdir($path,0755,TRUE);
                }
            }
        }
        return $path . $str . $this->_cacheFileExtension;
    }
}