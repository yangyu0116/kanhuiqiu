<?php
class UserModel extends BaseModel
{
	private $user_table = 'tbl_user';
	private $cookie_user_table = 'tbl_cookie_user';
    private $search_history_table = 'tbl_search_history';

    public function find_user_search_list($uid)
    {
		$limit_num = UserConfig::$search_num;

		$sql = 'select wd,orderby from `'.$this->search_history_table.'` where uid="'.$uid.'" order by orderby desc,id desc limit '. $limit_num;
		$res = $this->do_sql($sql);

		return $res;
    }

	public function add_user_search($uid, $uname, $wd)
    {
		$limit_num = UserConfig::$search_num;

		$search_count = $this->do_sql('select count(*) as count from `'.$this->search_history_table.'` where uid="'.$uid.'" limit 1');
		if ($search_count[0]['count'] >= $limit_num){
			$this->do_sql('delete from `'.$this->search_history_table.'` where uid="'.$uid.'" order by orderby asc,id asc limit 1');
		}

		$sql = 'insert into `'.$this->search_history_table.'` set uid="'.$uid.'",uname="'.$uname.'",wd="'.$wd.'"';
		$this->do_sql($sql);

		return true;
    }

	public function add_cookie_user($uid)
    {
		$sql = 'insert into `'.$this->cookie_user_table.'` set 
				uid="'.$uid.'",
				reg_time="'.date("Y-m-d H:i:s",GlobalConfig::$timestamp).'",
				reg_ip="'.HttpIpRequest::getUserClientIp().'"';
		$this->do_sql($sql);
		
		return true;
    }

}
