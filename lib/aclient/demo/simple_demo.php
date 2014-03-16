<?php

$AClientGlobalConf=array(         ///<  客户端的全局配置
    'ZookeeperHost'=>array(       ///< zookeeper的地址
        '10.23.247.231:2181',
        '10.23.247.231:2181',
        '10.23.247.231:2181',
    ),
);

require_once('../aclient.php');

/* 设置AClient全局配置 */
AClient::SetGlobalConf($AClientGlobalConf);

$AntispamConf=array(        ///<  调用具体服务的配置
    'Source'=>'Galileo',          ///< 服务器配置的来源，Local:从本地获取，Galileo:从资源定位服务器获取
    'Protocol'=>'Http',           ///<  协议的类型，可为Http或Nshead
    'Scheduler'=>'Random',        ///<  均衡策略，可为Random:随机选择后端, First:始终选择第一个可用的后端

    'GalileoConf'=>array(   ///<  Galileo方式的配置
        'Path'=>'/baidu/ns/ksarch/archproxy/antispam',   ///< zookeeper结点路径
    ),
);

$client=new AClient();

/* 设置具体服务的配置，返回true表示成功 */
$ret = $client->SetConf($AntispamConf);

/* 返回处理过程的错误信息 */
var_dump($client->GetLastError());

/* Http请求的输入数据，第二种格式
 * url: 请求url中的path和query string
 * data: 请求的post原始数据
 */
$input=array(
    'url'=>'index.php?service=Commit&pid=test&tk=&key=0&log_id=0',
    'data'=>file_get_contents("20001.pack"),//mc_pack_array2pack($data),
);

/* 发送Http请求，并返回结果 */
$output = $client->Call($input);
var_dump($client->GetLastError());

/* Http请求的返回结果
 * code: Http返回码
 * data: 返回数据
 */
var_dump($output);

?>
