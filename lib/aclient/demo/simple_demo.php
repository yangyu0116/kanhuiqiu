<?php

$AClientGlobalConf=array(         ///<  �ͻ��˵�ȫ������
    'ZookeeperHost'=>array(       ///< zookeeper�ĵ�ַ
        '10.23.247.231:2181',
        '10.23.247.231:2181',
        '10.23.247.231:2181',
    ),
);

require_once('../aclient.php');

/* ����AClientȫ������ */
AClient::SetGlobalConf($AClientGlobalConf);

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
var_dump($client->GetLastError());

/* Http������������ݣ��ڶ��ָ�ʽ
 * url: ����url�е�path��query string
 * data: �����postԭʼ����
 */
$input=array(
    'url'=>'index.php?service=Commit&pid=test&tk=&key=0&log_id=0',
    'data'=>file_get_contents("20001.pack"),//mc_pack_array2pack($data),
);

/* ����Http���󣬲����ؽ�� */
$output = $client->Call($input);
var_dump($client->GetLastError());

/* Http����ķ��ؽ��
 * code: Http������
 * data: ��������
 */
var_dump($output);

?>
