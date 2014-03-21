<?php
/**
 * 采用php的关联数组做配置文件
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
class ConfigArray extends AbstractConfig  
{
	public function __construct($config=array())
	{
	    if (!empty($config))
	    {
	        $this->setOption($config);
	    }
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
	    set_error_handler(array($this,'_includeErrorHandle'));
	    $this->_data = include($fileName);
	    restore_error_handler();	   
	    return TRUE;
	}
	
	public function save($fileName=NULL)
	{
	    //TODO
	}
	
	public function _includeErrorHandle()
	{
	    $this->error(AbstractConfig::INCLUDE_FILE_ERRNO,'Config : include file failure! fileName[' . $this->_fileName . ']');
	}
}