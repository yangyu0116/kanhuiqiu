<?php

	/**
	 * initial framework's environment  
	 *
	 * initial default include_path, autoload, context and so on,
	 * this file is required by framework/common/common.conf.php
	 * which is auto prepended before every request.
	 *
	 * @package bingo/framework/common
	 * @author  liubin01@baidu.com 
	 */
	define('ROOT_PATH', dirname(__FILE__).'/../../');

	define('WEBROOT_PATH',       ROOT_PATH.'webroot/');
	define('UI_PATH',            ROOT_PATH.'ui/');
	define('MODULE_PATH',        ROOT_PATH.'module/');
	define('CACHE_PATH',         ROOT_PATH.'cache/');
	define('COMMON_PATH',        ROOT_PATH.'common/');
	define('TEMPLATE_PATH',      ROOT_PATH.'template/');
	define('SCRIPT_PATH',        ROOT_PATH.'script/');	
	define('CONFIG_PATH',        ROOT_PATH.'config/');
	define('LIB_PATH',           ROOT_PATH.'lib/');

	define('FRAMEWORK_PATH',         ROOT_PATH.'framework/');
    define('FRAMEWORK_ACTIONS_PATH', ROOT_PATH.'framework/actions/');

	// framework reserved hooks
	define('HOOK_BEFORE_REQUEST_PROCESS', '__beforeRequestProcess__');
	define('HOOK_AFTER_REQUEST_PROCESS',  '__afterRequestProcess__');
	define('HOOK_BEFORE_ACTION_EXECUTE',  '__beforeActionExecute__');
	define('HOOK_AFTER_ACTION_EXECUTE',   '__afterActionExecute__');
	define('HOOK_PHP_ERROR',              '__phpError__');
	define('HOOK_PHP_EXCEPTION',          '__phpException__');

	define('HOOK_BEFORE_SPECIFY_ACTION_EXECUTE_PREFIX', 
								'__hookBeforeSpecifyActionExecutePrefix__');
	define('HOOK_AFTER_SPECIFY_ACTION_EXECUTE_PREFIX',
								'__hookAfterSpecifyActionExecutePrefix__');
	define('HOOK_ERRNO_PREFIX', '__hookErrnoPrefix__');
	define('HOOK_ACTIONCHAIN_FAILED', '__hookActionChainFailed__');

	/** 
	 * the prefix of the special key which is set to 
	 * the context's dictionary by framework
	 */
	define('FRAMEWORK_RESERVED_PREFIX', '__framework__');
	define('PROPERTY_ACTIONCHAIN_FAILED_INDEX',
                     FRAMEWORK_RESERVED_PREFIX.'__ActionChainFailedIndexKey__');

    date_default_timezone_set('Asia/Chongqing');

    // 计算启动时间点
    $requestTime = gettimeofday();
    define('REQUEST_TIME_MS', intval($requestTime['sec']*1000 + $requestTime['usec']/1000));

    ini_set('include_path', CONFIG_PATH.':'.ini_get('include_path'));

	/**
     * @brief bingo原来采用__autoload实现类自动加载
     *        由于smarty3也需要自动加载并采用spl_autoload机制
     *        这个机制会导致__autoload机制失效，所以将bingo自动加载也改为spl_autoload实现
     *  @ref  http://php.net/manual/en/function.spl-autoload-register.php
     */
    function bingoAutoload($className)
    {
        if(AutoLoadConfig::USE_AUTOLOAD_CACHE) {
            return BingoUtils::quickLoadClass($className);
        }

        include_once $className.'.class.php';
	}
    spl_autoload_register('bingoAutoload');

    require_once CONFIG_PATH."AutoLoadConfig.class.php";
    require_once FRAMEWORK_PATH."common/BingoUtils.class.php";
	require_once CONFIG_PATH.'GlobalConfig.class.php';
	require_once LIB_PATH.'log/CLogger.class.php';
	require_once LIB_PATH.'ucrypt/Ucrypt.class.php';
	require_once LIB_PATH.'aclient/aclient.php';
	require_once LIB_PATH.'htmlparser/HtmlParser.class.php';
	require_once FRAMEWORK_PATH.'Context.class.php';

    // 生成logid
    define('REQUEST_ID', BingoUtils::genLogid($requestTime));

    // 初始化日志的logid
    CLogger::setLogId(REQUEST_ID);

	/**
	 * context of the request, during the request, there is only
	 * one instance of the class Context, Singleton Designed.
	 */
	global $context;

	$context = Context::getInstance();
	$ret = $context->initial();
	if (true !== $ret) {
        CLogger::fatal('context->initial failed', GlobalConfig::BINGO_LOG_ERRNO);
		exit;
	}

	if (false === GlobalConfig::$phpErrorReportingSwitch) {
        //	turn off php error reporting, error is handled by bingo framework.
		error_reporting(0);
	}

	if (true === GlobalConfig::$hookPhpErrorSwitch) {
		set_error_handler('error_handler');
	}

	if (true === GlobalConfig::$hookPhpExceptionSwitch) {
		set_exception_handler('exception_handler');
    }

    function error_handler() {
        // if error has been supressed with an @
        if (error_reporting() == 0) {
            return;
        }
		$args = func_get_args();
		Context::getInstance()->fireEvent(new Event(HOOK_PHP_ERROR, 
									  'framework/common/env_init.php',
									  $args)
		);			
	}

	function exception_handler() {
		$args = func_get_args();
		Context::getInstance()->fireEvent(new Event(HOOK_PHP_EXCEPTION, 
									  'framework/common/env_init.php',
									  $args)
		);
    }

	// require app's env_init.php which is a specification
	require_once ROOT_PATH.'common/env_init.php';
?>
