<?php
class SearchService
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
        $m = new SearchModel(SearchConfig::$cache_config, $this->storage->db, null); 

        $arrList = $m->find_list($lstParam, $intOffset, $intNum, $intResCount);

        if ($arrList === false) {
            CLogger::warning('ComicListModel find_list fail', GlobalConfig::BINGO_LOG_ERRNO, 
                array('params' => $lstParam, 'offset' => $intOffset, 'num' => $intNum, 'res_count' => $intResCount));
            return false;
        }

        //���б��������
        foreach ($arrList as &$item) {
            $item['author'] = $this->array_truncate($this->csv2array($item['author']), 12);
            $item['characters'] = $this->array_truncate($this->csv2array($item['characters']), 12);
            $item['type'] = $this->array_truncate($this->csv2array($item['type']), 12);
        }

        //����cache
        $this->cache_set($dataCacheKey, $arrList);
        $this->cache_set($cntCacheKey, $intResCount);

        //δ����cache
        $hc = 0;

        return $arrList;
    }
}
?>
