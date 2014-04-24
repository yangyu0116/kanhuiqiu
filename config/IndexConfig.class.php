<?php
class IndexConfig
{
	public static $tpl_name;
    public static $cache_config;
	public static $recommend_array;
}

IndexConfig::$cache_config = array(
    'use_cache' => false,
    'cache_expire_time' => 600,
);

IndexConfig::$tpl_name = 'basketball-index.html';
IndexConfig::$recommend_array[0]['wd'] = date('d日官方', strtotime('yesterday'));
IndexConfig::$recommend_array[1]['wd'] = '比赛集锦';
IndexConfig::$recommend_array[2]['wd'] = '5佳球';
