<?php
class SearchConfig
{
    public static $cache_config;
	public static $page_num;
	public static $tpl_name;
	public static $video_url_pre;
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

SearchConfig::$video_url_pre = 'http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid=';