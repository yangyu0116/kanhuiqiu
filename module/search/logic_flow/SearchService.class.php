<?php
class SearchService
{
    private $storage;
	private $rec_status; 

    public function __construct() 
	{
        $this->storage = new Storage('kanhuiqiu');
    }

    public function find_list($lst_param, $intOffset, $intNum, &$intResCount = 0, &$hc = 0, $rec_status = false)
    {

		if (empty($lst_param['wd'])){
			return false;
		}

        $m_search = new SearchModel(SearchConfig::$cache_config, $this->storage->db, null);
        $arrList = $m_search->find_list($lst_param, $intOffset, $intNum, $intResCount);

		$userinfo = Session::check_login();
		if ($userinfo && $rec_status){
			$m_user = new UserModel(UserConfig::$cache_config, $this->storage->db, null);
			$search_list = $m_user->find_user_search_list($userinfo['uid']);

			$is_exsit = 0;
			foreach ($search_list as $s){
				if ($lst_param['wd'] == $s['wd']){
					$is_exsit = 1;
				}
			}

			if (!$is_exsit){
				$m_user->add_user_search($userinfo['uid'], $userinfo['uname'], $lst_param['wd']);
			}
		}


        if ($arrList === false) {
            CLogger::warning('SearchModel find_list fail', GlobalConfig::BINGO_LOG_ERRNO, 
                array('params' => $lst_param, 'offset' => $intOffset, 'num' => $intNum, 'res_count' => $intResCount));
            return false;
        }

		if ($arrList){
			foreach ($arrList as &$l){
				$l['date'] = (date('Y',GlobalConfig::$timestamp)==date('Y', $l['createtime'])) ? date("n月d日", $l['createtime']) : date("Y年m月d日", $l['createtime']);
				$l['url']  = SearchConfig::$video_url_pre . str_replace(array('6-','-1'),'', $l['source_id']);
			}
		}
	


        //存入cache
        //$this->cache_set($dataCacheKey, $arrList);
        //$this->cache_set($cntCacheKey, $intResCount);

        //未命中cache
        $hc = 0;

        return $arrList;
    }

	public function find_list_by_array($lst_param, $rec_status = false)
    {
		if (!is_array($lst_param) || empty($lst_param)){
			return false;
		}
		
		$arrList = array();
		$has_cache = 0;
		$intOffset = 0;
		$intNum = SearchConfig::$page_num;
		$intResCount = 0;
		foreach ($lst_param as $param){

			$tmp = array();
			$tmp['wd'] = $param['wd'];
			$tmp['videos'] = $this->find_list($param, $intOffset, $intNum, $intResCount, $has_cache, $rec_status);

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
