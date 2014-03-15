<?php

	/**
	 * GlobalConfig.class.php's detail config 
	 *
	 * config GlobalConfig::$rootAction and GlobalConfig::$initActions
	 * @package bingo/config
	 * @author  liubin01@baidu.com
	 */
	class GlobalConfig {

		public static $isDebug;
		public static $hookBeforeRequestProcessSwitch;
		public static $hookAfterRequestProcessSwitch;
		public static $hookBeforeActionExecuteSwitch;
		public static $hookAfterActionExecuteSwitch;
		public static $hookBeforeSpecifyActionExecuteSwitch;
		public static $hookAfterSpecifyActionExecuteSwitch;
		public static $hookPhpErrorSwitch;
		public static $hookPhpExceptionSwitch;
		public static $phpErrorReportingSwitch;
        public static $rootAction;
        public static $LOG_CONFIG;

        public static $database;
		public static $redis;
        public static $master_database;

        // bingo����log���õ�errno
        // ����wf��־������ͬ��errno
        const BINGO_LOG_ERRNO = 1000;
	const DATABASE_TIMEOUT = 1;
        
        public static $default_url;
        public static $default_host;
	}

	/**
	 * tell the framework whether open the debug feather or not
	 */
	GlobalConfig::$isDebug = true;

	GlobalConfig::$hookBeforeRequestProcessSwitch = true;
	GlobalConfig::$hookAfterRequestProcessSwitch  = true;
	GlobalConfig::$hookBeforeActionExecuteSwitch  = true;
	GlobalConfig::$hookAfterActionExecuteSwitch   = true;
	GlobalConfig::$hookBeforeSpecifyActionExecuteSwitch = true;
	GlobalConfig::$hookAfterSpecifyActionExecuteSwitch = true;
	GlobalConfig::$hookPhpErrorSwitch             = true;
	GlobalConfig::$hookPhpExceptionSwitch         = true;
	GlobalConfig::$phpErrorReportingSwitch        = true;


	/**
     * initial root action
	 *
	 * 1st element of the array is the actionID : String
	 * 2nd element of the array is the class name of the Action : String
	 * 3rd element of the array is the parameter of method 
	 *     	                       Action::initial($object) : Object
	 */
	GlobalConfig::$rootAction  = array(
        'ActionController', 
        FRAMEWORK_ACTIONS_PATH.'/ActionController.class.php', 	
        ActionControllerConfig::$config
    );

    GlobalConfig::$LOG_CONFIG = array(
        // ��־�������ã�0x07 = LOG_LEVEL_FATAL|LOG_LEVEL_WARNING|LOG_LEVEL_NOTICE
        'intLevel'			=> 0xff,
        //'intLevel'			=> 0x07,
        // ��־�ļ�·����wf��־Ϊbingo.log.wf
        'strLogFile'		=> ROOT_PATH.'/log/bingo.log',
        // ��λ:byte, 0��ʾ����
        'intMaxFileSize'    => 2000000000,
        // ������־·����������Ҫ��������
        'arrSelfLogFiles'	=> array()
    );
    // ������CLoggerʹ��
    $GLOBALS['LOG'] = GlobalConfig::$LOG_CONFIG;


	//���ݿ�    
   //���ݿ�����
    // - �������ö�����ݿ�
    // - Ĭ��ʹ�õ�һ������, �ڵ�һ���������ӳ���ʱʹ�ñ�������
    GlobalConfig::$database = array(
         #tcĬ������
        array(
           'host' => '127.0.0.1',
           'username'=>'video',
           'password'=>'video',
           'port'=>'3306'
        )
    );  

	//memcached
    GlobalConfig::$redis = array(
	   'host' => '127.0.0.1',
	   'port'=>'11211'
    );
    
    GlobalConfig::$default_url = 'http://www.kanhuiqiu.com/error.html';
    GlobalConfig::$default_host = 'http://www.kanhuiqiu.com';

