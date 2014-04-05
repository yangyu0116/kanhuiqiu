<?php
class UserService
{
    private $storage; 

    public function __construct()
    {
        $this->storage = new Storage('kanhuiqiu');
    }

    public function find_user_search_list($uid)
    {
        $m = new UserModel(UserConfig::$cache_config, $this->storage->db, null); 

        $arrList = $m->find_user_search_list($uid);

        if ($arrList === false) {
            CLogger::warning('UserModel find_list fail', GlobalConfig::BINGO_LOG_ERRNO, 
                array('params' => $lstParam, 'offset' => $intOffset, 'num' => $intNum, 'res_count' => $intResCount));
            return false;
        }else{
		
		
		}

        //$this->cache_set($dataCacheKey, $arrList);
        //$this->cache_set($cntCacheKey, $intResCount);

        $hc = 0;

        return $arrList;
    }
}
