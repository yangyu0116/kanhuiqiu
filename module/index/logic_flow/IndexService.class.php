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
		$search_list = array();
		foreach (IndexConfig::$recommend_array as $k => $rec){
			$search_list[$k]['wd'] = $rec['wd'];
		}

		$search_service = new SearchService();
		$video_list = $search_service->find_list_by_array($search_list, false);

		return $video_list;
    }

	
}
