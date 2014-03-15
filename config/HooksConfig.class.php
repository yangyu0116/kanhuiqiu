<?php

	/**
	 * global hooks' detail config
	 *
	 * 1st element of the outer array is the filepath which need to be included
	 * for running the hook
	 *
	 * 1st element of the inner array is the function name or the class/object 
	 * 2nd element of the inner array is the method name or the data object
	 * 3rd element of the inner array is the data object
	 *
	 * eg:
	 * HooksConfig::$config['beforeRequestProcess'][] = array(
 	 *						'hook_include_path',
	 *						array(
	 *							'functionName'
	 *						)
	 * );
	 * 
	 * HooksConfig::$config['beforeRequestProcess'][] = array(
 	 *						'hook_include_path',
	 *						array(
	 *							'functionName',  
	 *							$funcParam
	 *						)
	 * );
	 * 
	 * HooksConfig::$config['beforeRequestProcess'][] = array(
 	 *						'hook_include_path',
	 *						array(
	 *							'Class::method'
	 *						)
	 * );
	 * 
	 * HooksConfig::$config['beforeRequestProcess'][] = array(
 	 *						'hook_include_path',
	 *						array(
	 *							'Class::method', 
	 *							$methodParam
	 *						)
	 * );
	 *     
	 * HooksConfig::$config['beforeRequestProcess'][] = array(
 	 *						'hook_include_path',
	 *			    		array(
	 *							$object
	 *						)
	 * );
	 *	
	 * HooksConfig::$config['beforeRequestProcess'][] = array(   
 	 *						'hook_include_path',
	 *			    		array(
	 *							$object, 
	 *							'objectMethod'
	 *						)
	 * );	
	 *
	 * HooksConfig::$config['beforeRequestProcess'][] = array( 
 	 *						'hook_include_path',
	 * 			   			array(
	 *							$object, 
	 *							'objectMethod', 
	 *							$methodParam
	 *						)
	 * );
	 *
	 * framework reserved hook name start with '__', app is not allowed to 
	 * use this prefix.
	 * currently, framework hook name list:
	 * 1. HOOK_BEFORE_REQUEST_PROCESS
	 *    which is fired before a request being processed
	 * 2. HOOK_AFTER_REQUEST_PROCESS
	 *    which is fired after a request having been processed
	 * 3. HOOK_BEFORE_ACTION_EXECUTE
	 *    which is fired before a action being executed
	 * 4. HOOK_AFTER_ACTION_EXECUTE 
	 *    which is fired after a action having been executed 
	 */

	class HooksConfig {
		public static $config;
	}
	HooksConfig::$config[HOOK_BEFORE_REQUEST_PROCESS][] =  array(
							CONFIG_PATH.'GlobalConfig.class.php',
							array(
								'onBeforeProcess'
							)
	);
	HooksConfig::$config[HOOK_AFTER_REQUEST_PROCESS][] =  array(
							CONFIG_PATH.'GlobalConfig.class.php',
							array(
								'onAfterProcess'
							)
	);
	HooksConfig::$config[HOOK_AFTER_REQUEST_PROCESS][] =  array(
							CONFIG_PATH.'GlobalConfig.class.php',
							array(
								'onAfterProcess2'
							)
	);
	HooksConfig::$config[HOOK_BEFORE_ACTION_EXECUTE][] =  array(
							CONFIG_PATH.'GlobalConfig.class.php',
							array(
								'onBeforeExecute'
							)
	);

	HooksConfig::$config[HOOK_AFTER_ACTION_EXECUTE][] =  array(
							CONFIG_PATH.'GlobalConfig.class.php',
							array(	
								'onAfterExecute'
							)
	);

	HooksConfig::$config[HOOK_PHP_ERROR][] =  array(
							CONFIG_PATH.'GlobalConfig.class.php',
							array(
								'php_error_handler'
							)
	);

	HooksConfig::$config[HOOK_PHP_EXCEPTION][] =  array(
							CONFIG_PATH.'GlobalConfig.class.php',
							array(
								'php_exception_handler'
							)
	);

	HooksConfig::$config[HOOK_ACTIONCHAIN_FAILED][] =  array(
							CONFIG_PATH.'GlobalConfig.class.php',
							array(
								'actionchain_failed_handler'
							)
	);


	HooksConfig::$config[HOOK_BEFORE_SPECIFY_ACTION_EXECUTE_PREFIX.'ActionController'][] = array(
							CONFIG_PATH.'HooksConfig.class.php',
							array(
								'beforeActionControllerExecute'
							)
	);

	HooksConfig::$config[HOOK_ERRNO_PREFIX.'123'][] = array(
							COMMON_PATH.'event_handler.php',
							array(
								'errno_123_handler'
							)
	);

	function php_error_handler($context, $event, $data) {
		$errorInfo = $event->object;
		CLogger::fatal("framework_php_error_handler errno={$errorInfo[0]},"
					  ."error={$errorInfo[1]},errorfile={$errorInfo[2]},"
					  ."errorline={$errorInfo[3]}", GlobalConfig::BINGO_LOG_ERRNO);
	}

	function php_exception_handler($context, $event, $data){
		$errorInfo = $event->object;
        CLogger::fatal('framework_php_exception_handler '.var_export($errorInfo, true),
						GlobalConfig::BINGO_LOG_ERRNO);
	}

	function onBeforeProcess($context, $event, $data) {
//		CLogger::trace('in the function : onBeforeProcess');
	}

	function onAfterProcess($context, $event, $data) {
//		CLogger::trace('in the function : onAfterProcess');
	}

    function onBeforeExecute($context, $event, $configData) {
        /*
		CLogger::trace('in the function : beforeActionExecute',
					   0,
					   array('actionID' => $event->object->actionID)
                   );
         */
	}

    function onAfterExecute($context, $event, $data) {
        /*
		$action = $event->object[0];
		CLogger::trace('in the function : afterActionExecute',
					   0,
					   array('actionID' => $action->actionID)
		);
         */
	}
	function beforeActionControllerExecute(){
//		CLogger::trace('beforeActionControllerExecute Hook');
	}
	function onAfterProcess2(){

	}
	function actionchain_failed_handler($context, $event, $data) {
		$v = $context->getProperty(PROPERTY_ACTIONCHAIN_FAILED_INDEX);
		$chain = $event->source;	
		CLogger::trace('in the actionchain_failed_handler failed',
						 0,
						 array(
							'ActionChain.failedIndex' => $v,
							'ActionChain.actions'	  => var_export($chain, true)
							)
		);
	}
?>
