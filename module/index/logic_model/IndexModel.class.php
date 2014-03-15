<?php
class IndexModel extends BaseModel
{
    /**
     * 数据表名
     **/
    private $dataTableName = '';

    /**
     * 根据查询条件查询动漫
     *
     * @param $strArea 地区字段
     * @param $strType 类型字段
     * @param $strProp 特征字段
     * @param $strAuthor 按作者筛选
     * @param $strStart 开播日期
     * @param $strOrder 排序字段
     * @param $intOffset 结果的起始位置
     * @param $intNum 所需的结果条数
     * @param $intResCount[out] 总结果条数，用于计算分页 
     * @return 视频结果
     **/
    public function find_list($strArea, $strType, $strProp, $strAuthor, $strStart, $strOrder, $intOffset, $intNum, &$intResCount, $is_ipad = false)
    {
		echo 'kanhuiqiu by yangyu@sina.cn';exit();   //——————debug——————


		$index_field = array('video_ids');
        $option = array('SQL_CALC_FOUND_ROWS');

        if (empty($strArea)) {
            $strArea = "all";
        }
        if (empty($strType)) {
            $strType = "all";
        }
        if (empty($strProp)) {
            $strProp = "all";
        }
        if (empty($strStart)) {
            $strStart = "all";
        }

		$index_key = $strOrder ."_type_". $strType ."_area_". $strArea ."_start_". $strStart ."_prop_". $strProp;
		$select_conds[] = "index_id = '". $index_key."'";

		$sa = new SQLAssember($this->db);
        $sql = $sa->getSelect($this->index_tablename,$index_field,$select_conds,$option);
        $this->debug_sql($sql);


		$first_result = $this->do_query($sql, $res_num);

		if (($res_num != 0) && ($first_result != false)) {

            $id_array = explode(',', $first_result[0]['video_ids']);
			$intResCount = count($id_array);
			//$count = substr_count($first_result[0]['video_ids'], ',')+1;

			//选取的列
			$fields = array('title', 'url', 'img_url', 'poster_url', 'author',
                        'area', 'type', 'prop', 'start', 'seq', 'finish',
                        'pubtime', 'intro', 's_intro', 'hot', 'sites', 'works_id');

            if ($intOffset >= $intResCount) {
                $intResCount = 0;
                return false;
            }
            for ($i = 0; $i < $intNum; $i++) {
                if ($intOffset + $i < $intResCount) {    
                    $id_list[] = $id_array[$intOffset+$i];
                } else {
                    break;
                }
            }
            $sec_conds[] = "works_id in ('" .implode('\',\'', $id_list) ."')";
			
            $sec_appends = array(sprintf("ORDER BY find_in_set(works_id, '%s')", implode(',', $id_list)));

            $sql = $sa->getSelect($this->dataTableName,$fields,$sec_conds,$option,$sec_appends);
            $this->debug_sql($sql);

            $finial_result = $this->do_query($sql, $res);

            return $finial_result;
        } else {
            return false;
        }

    }
}
?>
