<?php
/** 
* @file NetTool.class.php
* @brief 网络相关工具函数
* @author interma
* @date 2010-04-21
 */

class NetTool
{
	public static function get_xml_videos($host, $query, $pn, $rn, 
		$ctimeout, $rtimeout)
	{
		$format = 'http://%s/v?ct=335544320&word=%s&pn=%d&rn=%d&ty=10';
		$url = sprintf($format, $host, urlencode($query), intval($pn), intval($rn));
		
		$info = array();
		$response = http_get($url, 
			array('timeout'=>$rtimeout,'connecttimeout'=>$ctimeout), $info);
		
		//CLogger::warning($url);
		//CLogger::warning($response);
		if ($response === false)
		{
			CLogger::warning('http_get fail', 0, 
				array('host'=>$host,'url'=>$url, 'ret'=>$response));
			return array(false, 0);
		}
		
		if (!isset($info['response_code']))
		{
			CLogger::warning('http_get no response_code', 0, 
				array('host'=>$host,'url'=>$url));
			return array(false, 0);
		}
		   
		if (intval($info['response_code']) !== 200)
		{
			CLogger::warning('http_get response_code != 200', 0, 
				array('host'=>$host,'url'=>$url, 'response_code'=>$info['response_code']));
			return array(false, 0);
		}

		//var_dump($response);	

		$display_num = '0';
		list($display_num, $response) = StringTool::get_tag_text($response, '<dispnum>', '</dispnum>');
		if ($display_num === false)
			return array(false, 0);


		$video_arr = array();

		while (true)
		{
			list($body, $response) = StringTool::get_tag_text($response, '<res>', '</res>');
			if ($body === false)
				break;		

			$video = array();			

			list($alt, $body) = StringTool::get_tag_text($body, '<objAlt>', '</objAlt>');
			if ($alt === false)
				continue;
			else
				$video['alt'] = StringTool::remove_cdata_tag($alt);

			list($img_url, $body) = StringTool::get_tag_text($body, '<imgUrl>', '</imgUrl>');
			if ($img_url === false)
				continue;
			else
				$video['img_url'] = StringTool::remove_cdata_tag($img_url);

			list($video_url, $body) = StringTool::get_tag_text($body, '<videoUrl>', '</videoUrl>');
			if ($video_url === false)
				continue;
			else
				$video['video_url'] = StringTool::remove_cdata_tag($video_url);

			list($duration, $body) = StringTool::get_tag_text($body, '<duration>', '</duration>');
			if ($duration === false)
				continue;
			else
				$video['duration'] = StringTool::remove_cdata_tag($duration);

			list($title, $body) = StringTool::get_tag_text($body, '<restitle>', '</restitle>');
			if ($title === false)
				continue;
			else
				$video['title'] = strip_tags(StringTool::remove_cdata_tag($title));

			$video['tag'] = array();

			while (true)
			{
				list($tag, $body) = StringTool::get_tag_text($body, '<type>', '</type>');
				if ($tag === false)
					break;
				else
					$video['tag'][] = strip_tags(StringTool::remove_cdata_tag($tag));
			}

			$video_arr[] = $video;
		}

		return array($video_arr, intval($display_num));
	}
}

?>
