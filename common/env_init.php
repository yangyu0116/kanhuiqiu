<?php
    define('DB_PATH',               LIB_PATH.'/db/');
    define('HTTPPROXY_PATH',        LIB_PATH.'/http_proxy/');
    define('NSHEAD_CLIENT_PATH',    LIB_PATH.'/nshead_client/');
    define('TIMER_PATH',            LIB_PATH.'/timer/');
    define('STRING_PATH',           LIB_PATH.'/string_utils');
    define('UCRYPT_PATH',           LIB_PATH.'/ucrypt');
	define('CORESEEK_PATH',			LIB_PATH.'/coreseek');

    define('INDEX_MODULE_PATH',         MODULE_PATH.'index/logic_model/');
    define('INDEX_FLOW_PATH',           MODULE_PATH.'index/logic_flow/');
    define('SEARCH_MODULE_PATH',         MODULE_PATH.'search/logic_model/');
    define('SEARCH_FLOW_PATH',           MODULE_PATH.'search/logic_flow/');


    define('SMARTY_PATH',           LIB_PATH.'/smarty/libs');
    define('SMARTY_TEMPLATE_DIR',   TEMPLATE_PATH);
    define('SMARTY_COMPILE_DIR',    LIB_PATH.'/smarty/templates/templates_c/');
    define('SMARTY_CONFIG_DIR',     LIB_PATH.'/smarty/templates/config/');
    define('SMARTY_CACHE_DIR',      LIB_PATH.'/smarty/templates/cache/');
    
    define('HOST_PATH',             'http://'.$_SERVER['HTTP_HOST']);
    define('CSS_PATH',              'http://'.$_SERVER['HTTP_HOST'].'/static/css');
    define('IMAGE_PATH',            'http://'.$_SERVER['HTTP_HOST'].'/static/img');
    define('CACHEKEYSEPARATOR', '_');
    ini_set('include_path', ini_get('include_path')
    .':'.CONFIG_PATH
    .':'.COMMON_PATH
    .':'.UCRYPT_PATH
    .':'.DB_PATH
    .':'.HTTPPROXY_PATH
//	.':'.TIME_FORMATTER_PATH
    .':'.TIMER_PATH
    .':'.STRING_PATH
	.':'.CORESEEK_PATH
    .':'.INDEX_FLOW_PATH
    .':'.INDEX_MODULE_PATH
	.':'.SEARCH_FLOW_PATH
    .':'.SEARCH_MODULE_PATH
    ); 

    require_once SMARTY_PATH.'/Smarty.class.php';
    require_once CONFIG_PATH.'/IDCConfig.class.php';
    require_once TEMPLATE_PATH.'/CacheTimestamp.class.php';

?>
