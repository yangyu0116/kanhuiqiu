
<?php
class Antispam
{
    private $client;
   	

    private $ActsCtrlConf=array(        ///<  ���þ�����������
        'Source'=>'Galileo',          ///<  ���������õ���Դ��Local:�ӱ��ػ�ȡ��Galileo:����Դ��λ��������ȡ
        'Protocol'=>'Http',           ///<  Э������ͣ���ΪHttp��Nshead
        'Scheduler'=>'First',        ///<  ������ԣ���ΪRandom:���ѡ����, First:ʼ��ѡ���һ�����õĺ��
        'GalileoConf'=>array(   ///<  Galileo��ʽ������
            'Path'=>'/baidu/ns/ksarch/archproxy/actsctrl',   ///<  zookeeper���·��
                ),
            );
    
    private $ConfilterConf=array(        ///<  ���þ�����������
        'Source'=>'Galileo',          ///<  ���������õ���Դ��Local:�ӱ��ػ�ȡ��Galileo:����Դ��λ��������ȡ
        'Protocol'=>'Http',           ///<  Э������ͣ���ΪHttp��Nshead
        'Scheduler'=>'First',        ///<  ������ԣ���ΪRandom:���ѡ����, First:ʼ��ѡ���һ�����õĺ��
    
        'GalileoConf'=>array(   ///<  Galileo��ʽ������
            'Path'=>'/baidu/ns/ksarch/archproxy/confilter',   ///<  zookeeper���·��
                ),
            );
    
	public function __construct($AClientGlobalConf_param = NULL) 
    {
        $AClientGlobalConf=array(         ///<  �ͻ��˵�ȫ������
            'ZookeeperHost'=>array(       ///< zookeeper�ĵ�ַ
                '10.23.253.43:8181',
                '10.23.247.141:8181',
                '10.65.27.21:8181',
                '10.81.7.200:8181',
                '10.65.39.219:8181'
            ),
        );
        if($AClientGlobalConf_param == NULL)
        {
            AClient::SetGlobalConf($AClientGlobalConf); 
        }
        else
        {
            AClient::SetGlobalConf($AClientGlobalConf_param); 
        }
        $this->client=new AClient();
   	}

    public function check_content($arr_data)
    {
        $ret =$this->client->SetConf($this->ConfilterConf);
        //CLogger::warning('SetConf in checktitle', GlobalConfig::BINGO_LOG_ERRNO,  array('erro' => $client->GetLastError()));
        /*$reqs=array(
            array('groupid'=>0, 'content'=>$title),
            array('groupid'=>1, 'use_content'=>0),
        );*/
        $input=array(
            'url'=>'index.php?service=Confilter&pid=video&tk=video',
            'post'=>array(
                'reqs'=>json_encode($arr_data),
            ),
        );
        $output=$this->client->Call($input);
        $result = json_decode($output['data'], true);
        if($result['err_no'] !== 0)
        {
            CLogger::warning('check_content fail', GlobalConfig::BINGO_LOG_ERRNO,  $arr_reqs);
            return false;
        }
        return $result['ans'];
    }

    //1��ʾ������Ƶ��2��ʶ���Ĵ���
    public function query_actsctrl($arr_data, &$op_success)
    {
        $ret = $this->client->SetConf($this->ActsCtrlConf);
        $input=array(
            'url'=>'index.php?service=ActsCtrl&pid=video&tk=video&type=query',
            'post'=>array(
                'data'=>json_encode($arr_data),
            ),
        );
        $output=$this->client->Call($input);
        $ret = json_decode($output['data'], true);
        if($ret['err_no'] !== 0)
        {
            CLogger::warning('query_actsctrl fail', GlobalConfig::BINGO_LOG_ERRNO,  $arr_data);
            return false;
        }
        $code = $ret['result']['code'];
        if($code == '1')
        {
            $op_success = 2;
        }
        return true;
    } 


    public function mod_actsctrl($arr_data, &$op_success)
    {
        $ret =$this->client->SetConf($this->ActsCtrlConf);
        $input=array(
            'url'=>'index.php?service=ActsCtrl&pid=video&tk=video&type=submit',
            'post'=>array(
                'data'=>json_encode($arr_data),
            ),
        );
        $output=$this->client->Call($input);
        $ret = json_decode($output['data'], true);
        if($ret['err_no'] !== 0)
        {
            CLogger::warning('mod_actsctrl fail', GlobalConfig::BINGO_LOG_ERRNO,  $arr_data);
            return false;
        }
        $code = $ret['result']['code'];
        if($code == '1')
        {
            $op_success = 2;
        }
        return true;
    } 

}
?>
