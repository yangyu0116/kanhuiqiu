<?php
/***************************************************************************
 * 
 * Copyright (c) 2010 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/



/**
 * @file aclient_demo.php 
 * @author wangweibing(com@baidu.com)
 * @date 2010/11/19 15:06:14
 * @brief 
 *  
 **/

////////// 设置全局配置示例 //////////////////////////////////////////////

$AClientGlobalConf=array(         ///<  客户端的全局配置
    'ZookeeperHost'=>array(       ///< zookeeper的地址
        '10.23.247.231:2181',
        '10.23.247.231:2181',
        '10.23.247.231:2181',
    ),
    'ZookeeperBackupPath'=>'./zkbackup/',      ///<  zookeeper数据备份目录
    'ZookeeperUpdateTime'=>10,     ///<  更新zookeeper数据的时间间隔，单位s 

    'DisabledTime'=>5,            ///<  端口标记为失效的持续时间，单位s，0表示不标记失效，-1表示永远失效
);

require_once(dirname(__FILE__).'/../aclient.php');

/* 设置AClient全局配置 */
AClient::SetGlobalConf($AClientGlobalConf);


///////// 以资源定位方式访问http协议后端示例 /////////////////////

$AntispamConf=array(        ///<  调用具体服务的配置
    'Source'=>'Galileo',          ///<  服务器配置的来源，Local:从本地获取，Galileo:从资源定位服务器获取
    'Protocol'=>'Http',           ///<  协议的类型，可为Http或Nshead
    'Scheduler'=>'Random',        ///<  均衡策略，可为Random:随机选择后端, First:始终选择第一个可用的后端
    
    'HttpConf'=>array(      ///<  Http通信的配置
        'ConnectTimeOut'=>50,     ///<  连接超时，单位ms，默认为1000
        'WriteTimeOut'=>500,      ///<  写超时，单位ms，默认为1000
        'ReadTimeOut'=>5000,      ///<  读超时，单位ms，默认为1000
    ),

    'GalileoConf'=>array(   ///<  Galileo方式的配置
        'Path'=>'/baidu/ns/ksarch/archproxy/antispam',   ///<  zookeeper结点路径
    ),
);

$client=new AClient();

/* 设置具体服务的配置，返回true表示成功 */
$ret = $client->SetConf($AntispamConf);

/* 返回处理过程的错误信息 */
var_dump($client->GetLastError());

/* Http请求的输入数据，第一种格式
 * url: 请求url中的path，不含域名
 * get: 请求url中的query string，key-value对
 * post: 请求post中的query string，key-value对
 */
$input=array(
    'url'=>'index.php',
    'get'=>array(
        'service'=>'ActsCtrl',
        'pid'=>'dianping',
        'tk'=>'dianping',
        'type'=>'submit',
    ),
    'post'=>array(
        'data'=>json_encode(array('id'=>100)),
    ),
);

/* Http请求的输入数据，第二种格式
 * url: 请求url中的path和query string
 * data: 请求的post原始数据
 */
$input2=array(
    'url'=>'index.php?service=Commit&pid=test&tk=&key=0&log_id=0',
    'data'=>file_get_contents(dirname(__FILE__)."/20001.pack"),//mc_pack_array2pack($data),
);

/* 发送Http请求，并返回结果 */
$output = $client->Call($input);
var_dump($client->GetLastError());

/* Http请求的返回结果
 * code: Http返回码
 * data: 返回数据
 */
var_dump($output);


///////// 以本地配ip方式访问nshead协议后端示例 /////////////////////

$ActsCtrlConf=array(        ///<  调用具体服务的配置
    'Source'=>'Local',            ///<  服务器配置的来源，Local:从本地获取，Galileo:从资源定位服务器获取
    'Protocol'=>'Nshead',         ///<  协议的类型，可为Http或Nshead
    'Scheduler'=>'First',         ///<  均衡策略，可为Random:随机选择后端, First:始终选择第一个可用的后端
    
    'NsheadConf'=>array(    ///<  Nshead通信的配置
        'ConnectTimeOut'=>50,     ///<  连接超时，单位ms，默认为1000
        'WriteTimeOut'=>500,      ///<  写超时，单位ms，默认为1000
        'ReadTimeOut'=>5000,      ///<  读超时，单位ms，默认为1000
    ),

    'LocalConf'=>array(     ///<  本地配置的服务器信息
        'Server'=>array(
            array(
                'IP'=>'10.23.247.231',
                'Port'=>6001,
            ),
            array(
                'IP'=>'10.23.247.231',
                'Port'=>6003,
            ),
        ),
    ),
);

$client=new AClient();

/* 设置具体服务的配置，返回true表示成功 */
$client->SetConf($ActsCtrlConf);

/* 返回处理过程的错误信息 */
var_dump($client->GetLastError());

/* nshead请求的输入数据
 * body[必须]: 要传递的数据
 * id, log_id, provider等[可选]: 和nshead的定义一致
 */
$input = array(
    'log_id' => 100,
    'provider' => 'abc',
    'body' => mc_pack_array2pack(array('id'=>100)),
);

/* 发送Nshead请求，并返回结果 */
$output = $client->Call($input);
var_dump($client->GetLastError());

/* nshead的输出数据
 * body: 返回的数据
 * id, log_id, provider等: 和nshead的定义一致
 */
var_dump($output);

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
