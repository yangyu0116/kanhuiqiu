<?php
/** 
* @file StringTool.class.php
* @author interma
* @date 2010-03-18
 */

class StringTool
{
	public static function replace($str, $from, $to)
	{
		return trim(implode($to, explode($from, $str)), $to);	
	}
 	
	public static function post_param($name)
	{
		$val = '';
		if (array_key_exists($name, $_POST))
			$val = $_POST[$name];

        $val = htmlspecialchars($val, ENT_QUOTES);        
        /*		
		if (StringTool::sql_inject_check($val))
			$val = '';
		 */

		return $val;
    }

	public static function get_param($name)
	{
		$val = '';
		if (array_key_exists($name, $_GET))
			$val = $_GET[$name];

        $val = htmlspecialchars($val, ENT_QUOTES);        
        /*		
		if (StringTool::sql_inject_check($val))
			$val = '';
		 */

		return $val;
	}
		//封装jsonp数据生成接口，防止xss
	public static function gen_jsonp($array,$callback,$input_charset="gbk"){
        if(preg_match('/[A-Za-z0-9_]+/', $callback, $match)){
            $callback =  $match[0];
        }
        else{
			$callback="";
        }
		if($input_charset!="utf-8"||$input_charset!="UTF-8"){
			$array=EncodeHelper::mb_convert_array_deep($array,$input_charset,"utf-8");
		}

        header("Content-Type:application/x-javascript");

		if(!empty($callback)){
			return $callback.'('.json_encode($array).')';
		}else{
			return json_encode($array);
		}
	}
	
	public static function truncate($str, $len)
	{
		if (mb_strlen($str, 'gbk') > $len)
		{
			$str = mb_substr($str, 0, $len, 'gbk').'...';
		}
		return $str;
	}

	public static function get_tag_text($str, $beg_tag, $end_tag)
	{
		$beg = strpos($str, $beg_tag);
		$end = strpos($str, $end_tag);
		if ($beg === false || $end === false || $end <= $beg)
			return array(false, $str);

		$body = substr($str, $beg+strlen($beg_tag), $end-$beg-strlen($beg_tag));
		$other = substr($str, $end+strlen($end_tag));

		return array($body, $other);
	}

	public static function remove_cdata_tag($str)
	{
		list($inner, $other) = StringTool::get_tag_text(trim($str), '<![CDATA[', ']]>');
		if ($inner !== false)
			return $inner;
		else
			return $str;
	}

	public static function get_baidu_uid()
	{
		$uid = '';
		if (isset($_COOKIE['BAIDUID']))
		{
			$uid = $_COOKIE['BAIDUID'];
			$uid = substr($uid, 0, 32);
		}
		return $uid;
	}
	
	public static function get_referer()
	{
		$referer = '';
		if (isset($_SERVER["HTTP_REFERER"]))
		{
			$referer = $_SERVER["HTTP_REFERER"];
		}
		return $referer;
	}

	public static function get_domain($url)
	{
		//$url = 'http://www.51php.net/index.php?referer=51php.net'; 
		//string(13) "www.51php.net"
		$arr_url = parse_url($url);

		return $arr_url['host'];
	}

	/** 
		* @brief 生成memcached的key
		* 
		* @param $subsys 子系统名称
		* @param $custom 自定义部分
		* 
		* @return 
	 */
	public static function get_mc_key($subsys, $custom)
	{
		$key = sprintf('[_MK_][%s]%s', $subsys, $custom);		
		return $key;
	}

	public static function get_sec($time)
	{
		$dt_element=explode(" ",$time);
		$date_element=explode("-",$dt_element[0]);
		$time_element=explode(":",$dt_element[1]);
		return mktime(
			intval($time_element[0]),intval($time_element[1]),intval($time_element[2]),
			intval($date_element[1]),intval($date_element[2]),intval($date_element[0]));
	}

    //计算抽样比率
    public static function sample_rate($field)
    {
        $hash_str = md5($field);
        #CLogger::debug('hash:'.$hash_str);
        $rate = 0;
        for ($i = 0; $i < strlen($hash_str); $i++) 
        {
            $value = ord($hash_str[$i]) - ord('0');
            $rate = ($rate + $value) % 100;
        }
        #CLogger::debug('rate:'.$rate);
        return $rate;
    } 


	/**
	 * @brief 生成外站可以访问的图片地址
	 *
	 * @param [in] string $img string to be checked
	 * @return  $img 
	 * @date 2013/05/08 15:11:53
	**/
	public static function get_no_refer_img($img, $width = 0, $height = 0)
    {
		//使用图云压图供第三方使用
		$key = 'wisetimgkey_noexpire_3f60e7362b8c23871c7564327a31d9d7';
		$sec = '1366351082';
		$src = $img;
		
		$size = 4;
		if ($width){
			$size = 'w'.$width;
		}

		return 'http://timg.baidu.com/timg?video&quality=100&size='.$size.'&sec='.$sec.'&di='.md5($key.$sec.$src).'&src='.urlencode($src);
	}
}

?>
