<?php
class SearchConfig
{
    public static $cache_config;
}

//cache配置
SearchConfig::$cache_config = array(
    //是否使用cache
    'use_cache' => false,
    //cache过期时间(秒)
    'cache_expire_time' => 600,
);
?>
