<?php
class IndexConfig
{
    public static $cache_config;
}

//cache����
IndexConfig::$cache_config = array(
    //�Ƿ�ʹ��cache
    'use_cache' => false,
    //cache����ʱ��(��)
    'cache_expire_time' => 600,
);
?>
