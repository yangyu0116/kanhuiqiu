<?php

$AClientGlobalConf=array(         ///<  客户端的全局配置
    'ZookeeperHost'=>array(       ///< zookeeper的地址
        '10.23.247.231:2181',
        '10.23.247.231:2181',
        '10.23.247.231:2181',
    ),
   // 'DisabledTime' => 0,
);

require_once('../aclient.php');
AClient::SetGlobalConf($AClientGlobalConf);

function test1() {
    for($i = 0; $i < 100000; $i++ ) {
        AClientUtils::set_key("abc","efg",1);
        AClientUtils::get_key("abc");
    }
}

function testkey($key, $ttl, $sleep) {
    AClientUtils::set_key($key, "abc", $ttl);
    usleep($sleep * 1000000);
    $r = AClientUtils::get_key($key);
    var_dump($r);
}

function test2() {
    testkey("a", 0.5, 0.6);
    testkey("b", 0.5, 0.4);
    testkey("c", 0, 0);
    testkey("d", -1, 0.5);
}

function test_closest() {
    $conf=array(        ///<  调用具体服务的配置
        'Source'=>'Local',            ///<  服务器配置的来源，Local:从本地获取，Galileo:从资源定位服务器获取
        'Protocol'=>'Nshead',         ///<  协议的类型，可为Http或Nshead
        'Scheduler'=>'Closest',         ///<  均衡策略，可为Random:随机选择后端, First:始终选择第一个可用的后端

        'NsheadConf'=>array(    ///<  Nshead通信的配置
            'ConnectTimeOut'=>50,     ///<  连接超时，单位ms，默认为1000
            'WriteTimeOut'=>500,      ///<  写超时，单位ms，默认为1000
            'ReadTimeOut'=>5000,      ///<  读超时，单位ms，默认为1000
        ),

        'LocalConf'=>array(     ///<  本地配置的服务器信息
            'Server'=>array(
                array(
                    'IP'=>'0.0.0.0',
                    'Port'=>6003,
                ),
                array(
                    'IP'=>'0.23.247.231',
                    'Port'=>6002,
                ),
                array(
                    'IP'=>'10.23.247.231',
                    'Port'=>6001,
                ),
            ),
        ),

        'ClosestConf' => array(
            'ShuffleTopNum' => 2,
        ),
    );
    $client = new Aclient();
    $client->SetConf($conf);

    $input = array(
        'log_id' => 100,
        'provider' => 'abc',
        'body' => mc_pack_array2pack(array('id'=>100)),
    );
    $output = $client->Call($input);
    var_dump($output);
    var_dump($client->GetLastError());
}
/* 设置AClient全局配置 */

test_closest();

function call_antispam() {
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

    /* Http请求的输入数据，第二种格式
     * url: 请求url中的path和query string
     * data: 请求的post原始数据
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

    /* 发送Http请求，并返回结果 */
    $output = $client->Call($input);
    return $output;
}

for($i = 0; $i < 20; $i++ ) {
    $t0 = gettimeofday(true);
    $output = call_antispam();
    $t1 = gettimeofday(true);
    var_dump($t1 - $t0);
}
var_dump($output);

?>
