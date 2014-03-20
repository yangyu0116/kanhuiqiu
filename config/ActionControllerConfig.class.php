<?php

	/**
	 * ActionController object's detail config
	 *
	 * different ActionController object may have different
	 * ActionControllerConfig object.
	 * the key of the array urlMapping is the url regular pattern
	 * the value of the array urlMapping is the handler action of the reg pattern
	 *
	 * @package bingo/config
	 * @author  liubin01@baidu.com
	 */

	class ActionControllerConfig {
		public static $config;
	}

	/*
	路由配置注意事项：
	*/

    ActionControllerConfig::$config = array(
	    //搜索结果页面
        '/^\/s/' => array(
                            'search',
                            UI_PATH.'/search/SearchAction.class.php',
                            null,
                            null
        ),
        //视频首页
        '/^(\/$|\/\?)/' => array(
                            'index',
                            UI_PATH.'/index/IndexAction.class.php',
                            null,
                            null
        ),
         //默认
        '/.*/' => array(
                            'default',
                            UI_PATH.'/DefaultAction.class.php',
                            null,
                            null
        )
    );

?>
