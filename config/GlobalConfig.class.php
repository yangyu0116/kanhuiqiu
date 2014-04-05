<?php
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

        const BINGO_LOG_ERRNO = 1000;
		const DATABASE_TIMEOUT = 1;
        
        public static $default_url;
        public static $default_host;

		public static $timestamp;
		public static $strhash;
	}

	/**
	 * tell the framework whether open the debug feather or not
	 */
	GlobalConfig::$isDebug = false;

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
        // 日志级别配置，0x07 = LOG_LEVEL_FATAL|LOG_LEVEL_WARNING|LOG_LEVEL_NOTICE
        'intLevel'			=> 0xff,
        //'intLevel'			=> 0x07,
        // 日志文件路径，wf日志为bingo.log.wf
        'strLogFile'		=> ROOT_PATH.'/log/bingo.log',
        // 单位:byte, 0表示无限
        'intMaxFileSize'    => 2000000000,
        // 特殊日志路径，根据需要自行配置
        'arrSelfLogFiles'	=> array()
    );
    // 导出给CLogger使用
    $GLOBALS['LOG'] = GlobalConfig::$LOG_CONFIG;


	//数据库    
   //数据库配置
    // - 可以配置多个数据库
    // - 默认使用第一项配置, 在第一项配置连接出错时使用备用配置
    GlobalConfig::$database = array(
         #tc默认配置
        array(
           'host' => $_SERVER['DB_HOST'],
           'username' => $_SERVER['DB_USER'],
           'password' => $_SERVER['DB_PASS'],
           'port' => $_SERVER['DB_PORT']
        )
    );  

	//memcached
    GlobalConfig::$redis = array(
	   'host' => '127.0.0.1',
	   'port'=>'6379'
    );
    
    GlobalConfig::$default_url = 'http://www.kanhuiqiu.com/error.html';
    GlobalConfig::$timestamp = 'http://www.kanhuiqiu.com';

	GlobalConfig::$timestamp = time();
	GlobalConfig::$strhash = 'khq_yy';
