<?php
/***************************************************************************
 * 
 * Copyright (c) 2011 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
 
 
 
/**
 * @file test/test.php
 * @author wangweibing(com@baidu.com)
 * @date 2011/05/13 17:39:50
 * @brief 
 *  
 **/



require_once(dirname(__FILE__)."/../mcclient.class.php");
$g_conf = array(
    'ZookeeperHost' => array(
        '10.32.54.38:2181',
    ),
);
AClient::SetGlobalConf($g_conf);

$mc_conf = array(
    'pid' => 'test',
    'default_expire' => 10, 
    'curr_idc' => 1,
    'zk_path' => '/baidu/ns/ksarch/cache',
);
$mc = new McClient($mc_conf);
$ret = $mc->add('abdaad','efg');
var_dump($ret);


/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
