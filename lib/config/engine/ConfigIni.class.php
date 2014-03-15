<?php
/**
 * ini的配置文件统一访问接口
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
class ConfigIni extends AbstractConfig  
{
	public function __construct($config=array())
	{
		$this->setOption($config);
	}
	
	public function setOption($config)
	{
	    if (isset($config['fileName']))
	    {
	        $this->setFileName($config['fileName']);
	    }
	    parent::_setOption($config);
	}	
	public function load($fileName=NULL)
	{
	    if (is_null($fileName))
	    {
	        $fileName = $this->_fileName;
	    }
	    else
	    {
	        $this->_fileName = $fileName;
	    }
	    parent::_cacheLoad($fileName,array($this,'parseFile'));
	    return $this->_data;
	}
	
    public function parseFile($fileName)
	{
	    set_error_handler(array($this,'_parseIniErrorHandle'));
	    $this->_data = parse_ini_file($fileName,true);
	    restore_error_handler();	   
	}
	/**
	 * TODO
	 *
	 */
	public function save($fileName=NULL)
	{
	    
	}
	
	public function _parseIniErrorHandle($errno, $errstr, $errfile, $errline)
	{
	    $this->error(AbstractConfig::PARSE_INI_ERROR,'Config parse_ini_file failure!fileName['.$this->_fileName.']');
	}
}