<?php
/**
 * Config�����ļ������ࡣ
 * 1��Ŀǰ֧��������ʽ�������ļ�: PHPԭ������array��INI�ļ����ٶȵ�configure��ʽ�ļ�
 * 2��֧��cache��Ĭ�ϲ���static���棬�����Զ��建�棨�����ļ���eacc��apc�ȵȣ���
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
	 * ����һ��config�࣬����$fileType��ȷ����
	 *
	 * @param �����ļ���·���������� $filePath
	 * @param �ļ����ͣ�ini,array,xml,config $fileType
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
		    //����config֧�ֵ�����
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
