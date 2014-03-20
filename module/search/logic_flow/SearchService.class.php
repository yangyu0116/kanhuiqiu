<?php
class SearchService
{
    //存储对象，封装memcached与mysql连接的创建流程
    private $storage; 

    public function __construct()
    {
        $this->storage = new Storage('kanhuiqiu');
		$this->storage->get_connect_db('kanhuiqiu');
    }

    /**
     * 根据条件从数据库或cache查询榜单
     *
     * @param $lstParam url参数列表
     * @param $intOffset 结果的起始位置
     * @param $intNum 所需的结果条数
     * @param $intResCount[out] 总结果条数，用于计算分页
     * @param $hc[out] 是否命中cache  
     * @return 专辑数组
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

        //将列表处理成数组
        foreach ($arrList as &$item) {
            $item['author'] = $this->array_truncate($this->csv2array($item['author']), 12);
            $item['characters'] = $this->array_truncate($this->csv2array($item['characters']), 12);
            $item['type'] = $this->array_truncate($this->csv2array($item['type']), 12);
        }

        //存入cache
        $this->cache_set($dataCacheKey, $arrList);
        $this->cache_set($cntCacheKey, $intResCount);

        //未命中cache
        $hc = 0;

        return $arrList;
    }
}
?>
