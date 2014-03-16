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

////////// ����ȫ������ʾ�� //////////////////////////////////////////////

$AClientGlobalConf=array(         ///<  �ͻ��˵�ȫ������
    'ZookeeperHost'=>array(       ///< zookeeper�ĵ�ַ
        '10.23.247.231:2181',
        '10.23.247.231:2181',
        '10.23.247.231:2181',
    ),
    'ZookeeperBackupPath'=>'./zkbackup/',      ///<  zookeeper���ݱ���Ŀ¼
    'ZookeeperUpdateTime'=>10,     ///<  ����zookeeper���ݵ�ʱ��������λs 

    'DisabledTime'=>5,            ///<  �˿ڱ��ΪʧЧ�ĳ���ʱ�䣬��λs��0��ʾ�����ʧЧ��-1��ʾ��ԶʧЧ
);

require_once(dirname(__FILE__).'/../aclient.php');

/* ����AClientȫ������ */
AClient::SetGlobalConf($AClientGlobalConf);


///////// ����Դ��λ��ʽ����httpЭ����ʾ�� /////////////////////

$AntispamConf=array(        ///<  ���þ�����������
    'Source'=>'Galileo',          ///<  ���������õ���Դ��Local:�ӱ��ػ�ȡ��Galileo:����Դ��λ��������ȡ
    'Protocol'=>'Http',           ///<  Э������ͣ���ΪHttp��Nshead
    'Scheduler'=>'Random',        ///<  ������ԣ���ΪRandom:���ѡ����, First:ʼ��ѡ���һ�����õĺ��
    
    'HttpConf'=>array(      ///<  Httpͨ�ŵ�����
        'ConnectTimeOut'=>50,     ///<  ���ӳ�ʱ����λms��Ĭ��Ϊ1000
        'WriteTimeOut'=>500,      ///<  д��ʱ����λms��Ĭ��Ϊ1000
        'ReadTimeOut'=>5000,      ///<  ����ʱ����λms��Ĭ��Ϊ1000
    ),

    'GalileoConf'=>array(   ///<  Galileo��ʽ������
        'Path'=>'/baidu/ns/ksarch/archproxy/antispam',   ///<  zookeeper���·��
    ),
);

$client=new AClient();

/* ���þ����������ã�����true��ʾ�ɹ� */
$ret = $client->SetConf($AntispamConf);

/* ���ش�����̵Ĵ�����Ϣ */
var_dump($client->GetLastError());

/* Http������������ݣ���һ�ָ�ʽ
 * url: ����url�е�path����������
 * get: ����url�е�query string��key-value��
 * post: ����post�е�query string��key-value��
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

/* Http������������ݣ��ڶ��ָ�ʽ
 * url: ����url�е�path��query string
 * data: �����postԭʼ����
 */
$input2=array(
    'url'=>'index.php?service=Commit&pid=test&tk=&key=0&log_id=0',
    'data'=>file_get_contents(dirname(__FILE__)."/20001.pack"),//mc_pack_array2pack($data),
);

/* ����Http���󣬲����ؽ�� */
$output = $client->Call($input);
var_dump($client->GetLastError());

/* Http����ķ��ؽ��
 * code: Http������
 * data: ��������
 */
var_dump($output);


///////// �Ա�����ip��ʽ����nsheadЭ����ʾ�� /////////////////////

$ActsCtrlConf=array(        ///<  ���þ�����������
    'Source'=>'Local',            ///<  ���������õ���Դ��Local:�ӱ��ػ�ȡ��Galileo:����Դ��λ��������ȡ
    'Protocol'=>'Nshead',         ///<  Э������ͣ���ΪHttp��Nshead
    'Scheduler'=>'First',         ///<  ������ԣ���ΪRandom:���ѡ����, First:ʼ��ѡ���һ�����õĺ��
    
    'NsheadConf'=>array(    ///<  Nsheadͨ�ŵ�����
        'ConnectTimeOut'=>50,     ///<  ���ӳ�ʱ����λms��Ĭ��Ϊ1000
        'WriteTimeOut'=>500,      ///<  д��ʱ����λms��Ĭ��Ϊ1000
        'ReadTimeOut'=>5000,      ///<  ����ʱ����λms��Ĭ��Ϊ1000
    ),

    'LocalConf'=>array(     ///<  �������õķ�������Ϣ
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

/* ���þ����������ã�����true��ʾ�ɹ� */
$client->SetConf($ActsCtrlConf);

/* ���ش�����̵Ĵ�����Ϣ */
var_dump($client->GetLastError());

/* nshead�������������
 * body[����]: Ҫ���ݵ�����
 * id, log_id, provider��[��ѡ]: ��nshead�Ķ���һ��
 */
$input = array(
    'log_id' => 100,
    'provider' => 'abc',
    'body' => mc_pack_array2pack(array('id'=>100)),
);

/* ����Nshead���󣬲����ؽ�� */
$output = $client->Call($input);
var_dump($client->GetLastError());

/* nshead���������
 * body: ���ص�����
 * id, log_id, provider��: ��nshead�Ķ���һ��
 */
var_dump($output);

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
