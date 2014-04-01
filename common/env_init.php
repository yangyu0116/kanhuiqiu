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

    define('USER_MODULE_PATH',         MODULE_PATH.'user/logic_model/');
    define('USER_FLOW_PATH',           MODULE_PATH.'user/logic_flow/');

    define('SMARTY_PATH',           LIB_PATH.'/smarty/libs');
    define('SMARTY_TEMPLATE_DIR',   TEMPLATE_PATH);
    define('SMARTY_COMPILE_DIR',    LIB_PATH.'/smarty/templates/templates_c/');
    define('SMARTY_CONFIG_DIR',     LIB_PATH.'/smarty/templates/config/');
    define('SMARTY_CACHE_DIR',      LIB_PATH.'/smarty/templates/cache/');
    
    define('HOST_PATH',             'http://'.$_SERVER['HTTP_HOST']);
    define('CSS_PATH',              'http://'.$_SERVER['HTTP_HOST'].'/static/css');
    define('IMAGE_PATH',            'http://'.$_SERVER['HTTP_HOST'].'/static/img');
    define('CACHEKEYSEPARATOR', '_');

	//判断系统分隔符
	if (PATH_SEPARATOR == ':'){
		$path_separator = ':';
	}else{
		$path_separator = ':.;';
	}

    ini_set('include_path', ini_get('include_path')
    .$path_separator.CONFIG_PATH
    .$path_separator.COMMON_PATH
    .$path_separator.UCRYPT_PATH
    .$path_separator.DB_PATH
    .$path_separator.HTTPPROXY_PATH
//	.$path_separator.TIME_FORMATTER_PATH
    .$path_separator.TIMER_PATH
    .$path_separator.STRING_PATH
	.$path_separator.CORESEEK_PATH
    .$path_separator.INDEX_FLOW_PATH
    .$path_separator.INDEX_MODULE_PATH
	.$path_separator.SEARCH_FLOW_PATH
    .$path_separator.SEARCH_MODULE_PATH
	.$path_separator.USER_FLOW_PATH
    .$path_separator.USER_MODULE_PATH
    ); 

    require_once SMARTY_PATH.'/Smarty.class.php';
    require_once CONFIG_PATH.'/IDCConfig.class.php';
    require_once TEMPLATE_PATH.'/CacheTimestamp.class.php';

?>
