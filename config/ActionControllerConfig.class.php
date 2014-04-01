<?php
	class ActionControllerConfig {
		public static $config;
	}
    ActionControllerConfig::$config = array(
        '/^\/s/' => array(
                            'search',
                            UI_PATH.'/search/SearchAction.class.php',
                            null,
                            null
        ),
        '/^(\/$|\/\?)/' => array(
                            'index',
                            UI_PATH.'/index/IndexAction.class.php',
                            null,
                            null
        ),
        '/.*/' => array(
                            'default',
                            UI_PATH.'/DefaultAction.class.php',
                            null,
                            null
        )
    );

?>
