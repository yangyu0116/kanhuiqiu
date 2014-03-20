<?php

	$ROOT_DIR = dirname($_SERVER['DOCUMENT_ROOT']);
	require_once($ROOT_DIR.'/framework/common/env_init.php');

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
