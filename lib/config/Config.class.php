<?php
/**
 * Config配置文件处理类。
 * 1、目前支持三种形式的配置文件: PHP原生数据array、INI文件、百度的configure格式文件
 * 2、支持cache。默认采用static缓存，可以自定义缓存（比如文件，eacc，apc等等）。
 * 
 * @author xuliqiang@baidu.com
 * @package config
 * @since 2009-10-21
 * 
 *
 */
if (!defined('LIB_CONFIG_ROOT_PATH'))
{
    define('LIB_CONFIG_ROOT_PATH',dirname(__FILE__));
}
require_once LIB_CONFIG_ROOT_PATH . '/AbstractConfig.class.php';
class Config
{	
	private static $_enableFileTypes = array('ini','array','configure');	
	
	const INVALID_FILE_TYPE = -1;
	
	public static $errno = 0;
	
	public static $errmsg = '';
	/**
	 * 产生一个config类，根据$fileType来确定。
	 *
	 * @param 配置文件的路径或者数组 $filePath
	 * @param 文件类型，ini,array,xml,config $fileType
	 * @return FALSE/Object
	 */
	public static function factory($fileType,$options=array())
	{
	    $fileType = strtolower($fileType);
		if (in_array($fileType,self::$_enableFileTypes))
		{
		    $cache = FALSE;
		    switch ($fileType)
		    {
		        case 'ini':	
		            require_once LIB_CONFIG_ROOT_PATH . '/engine/ConfigIni.class.php';
		            $cache = new ConfigIni($options);
		            break;
		        case 'array':
		            require_once LIB_CONFIG_ROOT_PATH . '/engine/ConfigArray.class.php';
		            $cache = new ConfigArray($options);
		            break;
		        case 'configure':
		            require_once LIB_CONFIG_ROOT_PATH . '/engine/ConfigConfigure.class.php';
		            $cache = new ConfigConfigure($options);
		            break;	    
		    }
		    if (is_subclass_of($cache,'AbstractConfig'))
		    {
		        if ($cache->load())
		        {
		            return $cache;
		        }
		        else 
		        {
		            self::_error($cache->getErrno(),$cache->getErrorMessage());
					return $cache;
		        }
		    }
		    else 
		    {
		        self::_error(self::INVALID_FILE_TYPE,'Config : invalid file type!filetype['.$fileType.']');
		    }
		    return FALSE;
		}
		else 
		{
		    //不是config支持的类型
		    self::_error(self::INVALID_FILE_TYPE,'Config : invalid file type!filetype['.$fileType.']');
		    return FALSE;
		}
	}
	
	protected static function _error($errno,$errmsg)
	{
	    self::$errno = $errno;
	    self::$errmsg = $errmsg;
	}
	
	public static function getErrno()
	{
	    return self::$errno;
	}
	
	public static function getErrmsg()
	{
	    return self::$errmsg;
	}
}
