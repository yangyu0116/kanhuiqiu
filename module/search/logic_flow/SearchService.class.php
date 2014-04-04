<?php
class SearchService
{
    private $storage; 

    public function __construct() 
	{
        $this->storage = new Storage('kanhuiqiu');
		$this->storage->get_connect_db('kanhuiqiu');
    }

    public function find_list($lst_param, $intOffset, $intNum, &$intResCount, &$hc)
    {
        $m = new SearchModel(SearchConfig::$cache_config, $this->storage->db, null); 

        $arrList = $m->find_list($lst_param, $intOffset, $intNum, $intResCount);

        if ($arrList === false) {
            CLogger::warning('SearchModel find_list fail', GlobalConfig::BINGO_LOG_ERRNO, 
                array('params' => $lst_param, 'offset' => $intOffset, 'num' => $intNum, 'res_count' => $intResCount));
            return false;
        }


        //存入cache
        //$this->cache_set($dataCacheKey, $arrList);
        //$this->cache_set($cntCacheKey, $intResCount);

        //未命中cache
        $hc = 0;

        return $arrList;
    }

	public function find_list_by_array($lst_param)
    {
		if (!is_array($lst_param) || empty($lst_param)){
			return false;
		}
		
		$arrList = array();
		//$intOffset = $intNum = $intResCount = 0;
		foreach ($lst_param as $param){

			$tmp = array();
			$tmp['wd'] = $param['wd'];
			$tmp['videos'] = $this->find_list($param, $intOffset, $intNum, $intResCount);

			$arrList[] = $tmp;
		}

        //存入cache
        //$this->cache_set($dataCacheKey, $arrList);
        //$this->cache_set($cntCacheKey, $intResCount);

        //未命中cache
        $hc = 0;

        return $arrList;
    }
}
