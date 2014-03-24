<?php
class IndexService
{
    //�洢���󣬷�װmemcached��mysql���ӵĴ�������
    private $storage; 

    public function __construct()
    {
        $this->storage = new Storage('kanhuiqiu');
	$this->storage->get_connect_db('kanhuiqiu');
    }

    /**
     * �������������ݿ��cache��ѯ��
     *
     * @param $lstParam url�����б�
     * @param $intOffset �������ʼλ��
     * @param $intNum ����Ľ������
     * @param $intResCount[out] �ܽ�����������ڼ����ҳ
     * @param $hc[out] �Ƿ�����cache  
     * @return ר������
     * @return
     **/
    public function find_list($lstParam, $intOffset, $intNum, &$intResCount, &$hc)
    {
        $m = new IndexModel(IndexConfig::$cache_config, $this->storage->db, null); 

        $arrList = $m->find_list($lstParam, $intOffset, $intNum, $intResCount);

        if ($arrList === false) {
            CLogger::warning('IndexModel find_list fail', GlobalConfig::BINGO_LOG_ERRNO, 
                array('params' => $lstParam, 'offset' => $intOffset, 'num' => $intNum, 'res_count' => $intResCount));
            return false;
        }


        //����cache
        //$this->cache_set($dataCacheKey, $arrList);
        //$this->cache_set($cntCacheKey, $intResCount);

        //δ����cache
        $hc = 0;

        return $arrList;
    }
}
?>
