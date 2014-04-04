<?php
class UserModel extends BaseModel
{
    private $dataTableName = 'tbl_search_history';

    public function find_user_search_list($uid)
    {
		$sql = 'select wd,set_top from `'.$this->dataTableName.'` where uid="'.$uid.'" order by id desc limit 10';
		$res = $this->do_sql($sql);

		return $res;
    }
}
?>
