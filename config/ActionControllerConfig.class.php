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
	·������ע�����
	*/

    ActionControllerConfig::$config = array(
	    //�������ҳ��
        '/^\/s/' => array(
                            'search',
                            UI_PATH.'/search/SearchAction.class.php',
                            null,
                            null
        ),
        //��Ƶ��ҳ
        '/^(\/$|\/\?)/' => array(
                            'index',
                            UI_PATH.'/index/IndexAction.class.php',
                            null,
                            null
        ),
         //Ĭ��
        '/.*/' => array(
                            'default',
                            UI_PATH.'/DefaultAction.class.php',
                            null,
                            null
        )
    );

?>
