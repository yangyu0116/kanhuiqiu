<?php
class IndexService
{
    private $storage; 

    public function __construct()
    {
        $this->storage = new Storage('kanhuiqiu');
    }

    public function find_list($lstParam, $intOffset, $intNum, &$intResCount, &$hc)
    {
        $m = new IndexModel(IndexConfig::$cache_config, $this->storage->db, null); 

        $arrList = $m->find_list($lstParam, $intOffset, $intNum, $intResCount);

        if ($arrList === false) {
            CLogger::warning('IndexModel find_list fail', GlobalConfig::BINGO_LOG_ERRNO, 
                array('params' => $lstParam, 'offset' => $intOffset, 'num' => $intNum, 'res_count' => $intResCount));
            return false;
        }


        //存入cache
        //$this->cache_set($dataCacheKey, $arrList);
        //$this->cache_set($cntCacheKey, $intResCount);

        //未命中cache
        $hc = 0;

        return $arrList;
    }

    public function recommend_list()
    {
        $recommend_array = array(
			'官方',
			'集锦',
			'录播',
			'5佳球'
		);
		
		$search_list = array();
		foreach ($recommend_array as $k => $rec){
			$search_list[$k]['wd'] = $rec;
		}

		$search_service = new SearchService();
		$video_list = $search_service->find_list_by_array($search_list, true);

		return $video_list;
    }

	
}
