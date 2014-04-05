<?php
class UserModel extends BaseModel
{
    private $table_name = 'tbl_search_history';

    public function find_user_search_list($uid)
    {
		$sql = 'select wd,orderby from `'.$this->table_name.'` where uid="'.$uid.'" order by orderby desc,id desc limit 10';
		$res = $this->do_sql($sql);

		return $res;
    }

	public function add_user_search($uid, $uname, $wd)
    {
		$sql = 'insert into `'.$this->table_name.'` set uid="'.$uid.'",uname="'.$unamme.'",wd="'.$wd.'"';
		$res = $this->do_sql($sql);

		return $res;
    }
}
?>
