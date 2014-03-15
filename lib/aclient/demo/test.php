<?php

$AClientGlobalConf=array(         ///<  �ͻ��˵�ȫ������
    'ZookeeperHost'=>array(       ///< zookeeper�ĵ�ַ
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
    $conf=array(        ///<  ���þ�����������
        'Source'=>'Local',            ///<  ���������õ���Դ��Local:�ӱ��ػ�ȡ��Galileo:����Դ��λ��������ȡ
        'Protocol'=>'Nshead',         ///<  Э������ͣ���ΪHttp��Nshead
        'Scheduler'=>'Closest',         ///<  ������ԣ���ΪRandom:���ѡ����, First:ʼ��ѡ���һ�����õĺ��

        'NsheadConf'=>array(    ///<  Nsheadͨ�ŵ�����
            'ConnectTimeOut'=>50,     ///<  ���ӳ�ʱ����λms��Ĭ��Ϊ1000
            'WriteTimeOut'=>500,      ///<  д��ʱ����λms��Ĭ��Ϊ1000
            'ReadTimeOut'=>5000,      ///<  ����ʱ����λms��Ĭ��Ϊ1000
        ),

        'LocalConf'=>array(     ///<  �������õķ�������Ϣ
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
/* ����AClientȫ������ */

test_closest();

function call_antispam() {
    $AntispamConf=array(        ///<  ���þ�����������
        'Source'=>'Galileo',          ///< ���������õ���Դ��Local:�ӱ��ػ�ȡ��Galileo:����Դ��λ��������ȡ
        'Protocol'=>'Http',           ///<  Э������ͣ���ΪHttp��Nshead
        'Scheduler'=>'Random',        ///<  ������ԣ���ΪRandom:���ѡ����, First:ʼ��ѡ���һ�����õĺ��

        'GalileoConf'=>array(   ///<  Galileo��ʽ������
            'Path'=>'/baidu/ns/ksarch/archproxy/antispam',   ///< zookeeper���·��
        ),
    );
    $client=new AClient();

    /* ���þ����������ã�����true��ʾ�ɹ� */
    $ret = $client->SetConf($AntispamConf);

    /* ���ش�����̵Ĵ�����Ϣ */

    /* Http������������ݣ��ڶ��ָ�ʽ
     * url: ����url�е�path��query string
     * data: �����postԭʼ����
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

    /* ����Http���󣬲����ؽ�� */
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
