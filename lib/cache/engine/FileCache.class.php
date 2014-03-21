<?php 
/**
 * �ļ�����
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
     * �Ƿ����serialize��ʽ���л�����
     *
     * @var bool
     */
    protected $_serialize = FALSE;
    /**
     * �����ļ��в���
     *
     * @var int
     */
    protected $_filePathLevel = 0;
    /**
     * ����У��ص�����
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
            	
            	//��ȡͷ
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
            		//����
            		flock($fp,LOCK_UN);
            		fclose($fp);
            		@unlink($fileName);
            	}
            	else 
            	{
            		//û�й���
            		$data = fread($fp,$_fileLen-$this->_headLen);
            		flock($fp,LOCK_UN);
            		fclose($fp);
            		if (!$data)
            		{            			
            			return FALSE;  
            		}
            		if ( $_validator!= 0 )
            		{
            			//TODOУ�������Ƿ���ȷ
            		}
            		if ( $_serialize )
            		{
            			//��Ҫ�����л�
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
            	//�ļ����Ȳ���
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
         * ���л�
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
            	//�Ǳ�����Ҫǿ�����л�
            	$value = serialize($value);
            	$_serialize = TRUE;
        	} 
        }        
        //�����ļ�ͷ��Ϣ
        $_validatorStr = '';
        if ( is_callable($this->_validatorCallback) )
        {
        	$_validatorStr = call_user_func_array($this->_validatorCallback,$value);
        }
        $head = $this->_buildHead($lifeTime,$_serialize,$this->_validatorCallback,$_validatorStr);
        //д������
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
     * ��������У��Ļص�����
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
    		//�����ϼ��ܴ�
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