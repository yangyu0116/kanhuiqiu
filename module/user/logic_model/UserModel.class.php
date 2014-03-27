<?php
class UserModel extends BaseModel
{
    /**
     * 数据表名
     **/
    private $dataTableName = '';

    /**
     * 根据查询条件查询动漫
     * @param $strOrder 排序字段
     * @param $intOffset 结果的起始位置
     * @param $intNum 所需的结果条数
     * @param $intResCount[out] 总结果条数，用于计算分页 
     * @return 视频结果
     **/
    public function find_user($param)
    {
		$sql = 'select uid,uname from tbl_user where uname="'.$param['uname'].'" limit 1';
		$res = $this->do_sql($sql);

		return $res;
    }
}
?>
