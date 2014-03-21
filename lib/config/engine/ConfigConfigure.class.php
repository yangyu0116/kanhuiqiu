<?php 
/**
 * configure配置文件的解析类。基于comconfig extension
 * @author xuliqiang@baidu.com
 * @since 2009-10-21
 * @package config
 *
 */
if (!defined('LIB_CONFIG_ROOT_PATH'))
{
    define('LIB_CONFIG_ROOT_PATH',dirname(__FILE__) . '/..');
}
require_once LIB_CONFIG_ROOT_PATH . '/AbstractConfig.class.php';
class ConfigConfigure extends AbstractConfig 
{
    private $_dir = './';
    
    private $_confFileName = '';
    
    private $_rangeFileName = '';
    
    public function __construct($config=array())
    {        
        $this->setOption($config);
    }
    
    public function setOption($config)
    {
        if (isset($config['dir']))
        {
            if ( is_dir($config['dir']) && file_exists($config['dir']) )
            {
                $this->_dir = rtrim($config['dir'],'/') . '/';        
            }
        }
        if (isset($config['conf_file_name']))
        {
            $this->_confFileName = $config['conf_file_name'];
        }
        if (isset($config['confFileName']))
        {
            $this->_confFileName = $config['confFileName'];
        }
        if (isset($config['range_file_name']))
        {
            $this->_rangeFileName = $config['range_file_name'];
        }
        if (isset($config['rangeFileName']))
        {
            $this->_rangeFileName = $config['rangeFileName'];
        }
        parent::_setOption($config);
    }
	
	public function load($fileName=NULL)
	{
	    if (!extension_loaded('comconfig'))
        {
            parent::error(AbstractConfig::CONFIGURE_EXTENSION_NOT_FOUND,'CONFIG comcofig extension is disabled!');
            return FALSE;
        }
        $key = sprintf('%s_%s_%s',$this->_dir,$this->_confFileName,$this->_rangeFileName);
        parent::_cacheLoad($this->_dir . '/' . $this->_confFileName,array($this,'parseConfigure'),$key);
        return $this->_data;
	}
	
	public function parseConfigure()
	{
	    set_error_handler(array($this,'__parseConfigureErrorHanlder'));
        if (empty($this->_rangeFileName))
        {
            $this->_data = config_load($this->_dir,$this->_confFileName);
        }
        else 
        {
            $this->_data = config_load($this->_dir,$this->_confFileName,$this->_rangeFileName);
        }
        restore_error_handler();
        if (!$this->_data)
        {
            $this->__parseConfigureErrorHanlder();
            return FALSE;
        }
        return TRUE;
	}
	/**
	 * TODO
	 *
	 * @param unknown_type $fileName
	 */
	public function save($fileName=NULL)
	{
	    
	}
	
	public function __parseConfigureErrorHanlder($errno, $errstr, $errfile, $errline)
	{
	    $this->error(AbstractConfig::CONFIGURE_PARSE_ERROR,'Config parse configure error!errno['.
	        config_errno().'],error_message['.config_error_message().']');
	}
}