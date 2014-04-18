<?php
class SearchConfig
{
    public static $cache_config;
	public static $page_num;
	public static $tpl_name;
}

//cache配置
SearchConfig::$cache_config = array(
    //是否使用cache
    'use_cache' => false,
    //cache过期时间(秒)
    'cache_expire_time' => 600,
);

SearchConfig::$page_num = 20;
SearchConfig::$tpl_name = 'search-common.html';