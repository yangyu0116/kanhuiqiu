<?php
class SearchModel extends BaseModel
{
    /**
     * 数据表名
     **/
    private $dataTableName = '';


    public function find_list($lstParam, $intOffset, $intNum, &$intResCount)
    {
		if (isset($lstParam['wd'])){
			$word = $lstParam['wd'];
		}else{
			$word = '比赛集锦';
		}

		if ($_SERVER['HTTP_HOST'] == 'k'){
			$sql = 'select title,url,pic,year,date from tbl_video where title like "%'.$word.'%" order by id desc limit 20 ';
			$result = $this->do_sql($sql);
			return $result;
		}

		$cl = new SphinxClient ();
		$cl->SetServer ( '127.0.0.1', 9312);
		//以下设置用于返回数组形式的结果
		$cl->SetArrayResult ( true );

		/*
		//ID的过滤
		$cl->SetIDRange(3,4);

		//sql_attr_uint等类型的属性字段，需要使用setFilter过滤，类似SQL的WHERE group_id=2
		$cl->setFilter('group_id',array(2));

		//sql_attr_uint等类型的属性字段，也可以设置过滤范围，类似SQL的WHERE group_id2>=6 AND group_id2<=8
		$cl->SetFilterRange('group_id2',6,8);
		*/

		//取从头开始的前20条数据，0,20类似SQl语句的LIMIT 0,20
		$cl->SetLimits(0,20);

		$cl->SetSortMode (SPH_SORT_ATTR_DESC, 'vid' );
		//$cl->setMatchMode (1);
		//在做索引时，没有进行 sql_attr_类型 设置的字段，可以作为“搜索字符串”，进行全文搜索

		$res = $cl->Query ($word, "*" );    //"*"表示在所有索引里面同时搜索，"索引名称（例如test或者test,test2）"则表示搜索指定的

		//如果需要搜索指定全文字段的内容，可以使用扩展匹配模式：
		//$cl->SetMatchMode(SPH_MATCH_EXTENDED);

		if ($res['total'] == 0){
			$cl->SetSortMode (SPH_SORT_RELEVANCE);
			$cl->setMatchMode (1);
			$res = $cl->Query ($word, "*" );    //"*"表示在所有索引里面同时搜索，"索引名称（例如test或者test,test2）"则表示搜索指定的
			if ($res['total'] == 0){
				return false;
			}
			//return false;
		}
		
		$id_arr = array();
		foreach ($res['matches'] as $r){
			$id_arr[] = $r['id'];
		}
		$id_str = implode(',',$id_arr);
		$sql = 'select title,url,pic,year,date from tbl_video where id in ('.$id_str.') ORDER BY find_in_set(id, "'.$id_str.'")';
		$res = $this->do_sql($sql);

		return $res;
    }
}
?>
