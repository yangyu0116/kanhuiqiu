<?php
class UserConfig
{
    public static $cache_config;
}

//cache����
UserConfig::$cache_config = array(
    //�Ƿ�ʹ��cache
    'use_cache' => false,
    //cache����ʱ��(��)
    'cache_expire_time' => 600,
);
?>
