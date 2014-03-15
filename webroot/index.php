<?php
echo '<center><img src="http://kanhuiqiu.com/static/building.jpg"></center><p><p><center>yangyu@sina.cn</center>';exit;
	/*
	 * the entry of every request
	 *
	 * all the requests are rewritten to index.php (configured in apache),
	 * and environment is already initialed by framework/common/common.conf.php
	 * which is auto prepended before every request, index.php will call
	 * the 'beforeRequestProcess' hook, the root action confingured in 
	 * bingo/config/GlobalConfig.class.php, and finally call the 
	 * 'afterRequestProcess' hook. Actually, framework/index.php is
	 * deployed at 'bingo/webroot/index.php'. 
	 *
	 * @package bingo/framework
	 * @author  liubin01@baidu.com
	 */
	require_once('/home/video/kanhuiqiu_com/framework/common/env_init.php');

	if (true === GlobalConfig::$hookBeforeRequestProcessSwitch) {
		// fire 'beforeRequestProcess' event
		$context->fireEvent(new Event(HOOK_BEFORE_REQUEST_PROCESS
									, 'index.php', null));	
	}	
	$context->callAction($context->rootAction->actionID);
	if (true === GlobalConfig::$hookAfterRequestProcessSwitch) {
		// fire 'afterRequestProcess' event
		$context->fireEvent(new Event(HOOK_AFTER_REQUEST_PROCESS
								    , 'index.php', null));
	}
?>
