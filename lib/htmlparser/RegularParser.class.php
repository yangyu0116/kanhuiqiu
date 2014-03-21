<?php

/**
 * @brief 采用正则方式解析页面，目前主要是对于视频网站
 * @author Administrator
 */

class RegularParser {
	// 抓取规则
	private static $pattern = array(
//      有编码问题，后续在升级提供支持
//      测试url：http://www.56.com/w50/play_album-aid-8713228_vid-NTU2NjI3OTI.html
//		array(
//		    'pn' => '/^http:\/\/www\.56\.com\/(.+)\/play_album-aid-(.+)\.html*/i', 
//		    'fn' => '_spiderFor56Playlist',
//			'type' => HPDef::HTML_TYPE_VIDEO,
//		),
		
		array(
		    'pn' => '/^http:\/\/(.+\.)*56\.com\/.*/i', 
		    'fn' => '_spiderFor56Api',
			'type' => HPDef::HTML_TYPE_VIDEO, 
		),
		array(
		    'pn' => '/^http:\/\/(.+\.)*tudou\.com\/.*/i', 
		    'fn' => '_spiderForTudou', 
			'type' => HPDef::HTML_TYPE_VIDEO, 
		),
		array(
		    'pn' => '/^http:\/\/(.+\.)*youku\.com\/.*/i', 
		    'fn' => '_spiderForYoukuApi', 
			'type' => HPDef::HTML_TYPE_VIDEO, 
		),
		array(
		    'pn' => '/^http:\/\/(.+\.)*xiyou\.cntv\.cn\/.*/i', 
		    'fn' => '_spiderForXiyouApi', 
			'type' => HPDef::HTML_TYPE_VIDEO, 
		),
		
		array(
		    'pn' => '/^http:\/\/v\.ku6\.com\/.+\/show_[0-9]+\/(.+)\.html/i', 
		    'fn' => '_spiderForKu6Api', 
			'type' => HPDef::HTML_TYPE_VIDEO, 
		),
		array(
		    'pn' => '/^http:\/\/v\.ku6\.com\/show\/(.+)\.html/i', 
		    'fn' => '_spiderForKu6Api', 
			'type' => HPDef::HTML_TYPE_VIDEO, 
        ),
	//	array(
	//	    'pn' => '/^http:\/\/(.+\.)*ku6\.com\/.*/i', 
	//	    'fn' => '_spiderForKu6Api', 
	//		'type' => HPDef::HTML_TYPE_VIDEO, 
	//	),
		array(
		    'pn' => '/^http:\/\/(.+\.)*qiyi\.com\/.*/i', 
		    'fn' => '_spiderForQiyiApi', 
			'type' => HPDef::HTML_TYPE_VIDEO, 
		),
		array(
		    'pn' => '/^http:\/\/(.+\.)*iqiyi\.com\/.*/i', 
		    'fn' => '_spiderForQiyiApi', 
			'type' => HPDef::HTML_TYPE_VIDEO, 
		),
		array(
		    'pn' => '/^http:\/\/(.+\.)*letv\.com\/.*/i', 
		    'fn' => '_spiderForLeTVApi', 
			'type' => HPDef::HTML_TYPE_VIDEO, 
		),
		array(
		    'pn' => '/^http:\/\/(.+\.)*joy\.cn\/.*/i', 
		    'fn' => '_spiderForJoyApi', 
			'type' => HPDef::HTML_TYPE_VIDEO, 
		),
/*		array(
		    'pn' => '/^http:\/\/bugu\.cntv\.cn\/.+\/classpage\/video\/[0-9]+\/.+\.shtml/i', 
		    'fn' => '_spiderForBuguApi', 
			'type' => HPDef::HTML_TYPE_VIDEO, 
        ),*/
		array(
		    'pn' => '/^http:\/\/(.+\.)*cntv\.cn\/.*/i', 
		    'fn' => '_spiderForBuguApi', 
			'type' => HPDef::HTML_TYPE_VIDEO, 
		),
		array(
		    'pn' => '/^http:\/\/(.+\.)*hualu5\.com\/.*/i', 
		    'fn' => '_spiderForHualu5Api', 
			'type' => HPDef::HTML_TYPE_VIDEO, 
		),
		array(
		    'pn' => '/^http:\/\/(.+\.)*tv\.sohu\.com\/.*/i', 
		    'fn' => '_spiderForSohuApi', 
			'type' => HPDef::HTML_TYPE_VIDEO, 
        ),
        array(
		    'pn' => '/^http:\/\/(.+\.)*video\.sina\.com\.cn\/.*/i', 
		    'fn' => '_spiderForSinaApi', 
			'type' => HPDef::HTML_TYPE_VIDEO, 
		),
	);
	const ERROR_NO_MATCH = 'no_match';
	
	public static function parser($url, &$results) {
		$arrUrlMatches = array();
        $arrResults = array();
        $error = '';
		foreach (self::$pattern as $v) {
			if(preg_match($v['pn'], $url, $arrUrlMatches)) {
				//echo "func: ".$v['fn']."<br/>";
				//$bol = $this->$v['fn']($this->url, $results, $arrUrlMatches);
				$results = call_user_func_array(array('self', $v['fn']), array($url, $arrUrlMatches, &$error));
				if ($results === false) {
					return sprintf("IN[URL:%s] FUNC:%s MATCHES:%s FAIL ERR:%s", $url, $v['fn'], print_r($arrUrlMatches, true), $error);
					$error = 'no no';
				}
				$results['type'] = $v['type'];
				$results['link'] = $url;
				return true;
			}
        }
        $error = 'no match';
		//echo "no match<br/>";
		return false;
	}
	
	private static function _spiderFor56Playlist($url, $arrUrlMatches, &$error) {
		$re = '';
		$bol = HPCurl::call($url, $re);
		if(!$bol) {
			return false;
		}
		$pattern = '/<title>(.+)<\/title>.*f_js_playObject\(\'(.+)\'\);/isU';
		if(!preg_match($pattern, $re, $matches)) {
			$error = 'preg_match fail';
			return false;
		}
		//哎56太不友好了
		$strVideoInfo = $matches[2];
		$arrTmp = explode('&', $strVideoInfo);
		$arrVideoInfo = array();
		if(count($arrTmp) == 1) {
			$error = 'arrTmp err';
			return false;
		}
		
		foreach ($arrTmp as $v) {
			list($key, $value) = explode('=', $v);
			$arrVideoInfo[trim($key)] = trim($value);
		}
		$arrResults = array();
		$arrResults['title'] = trim(($arrVideoInfo['tit']));
		$strPatternContent = '/<li id="videoinfo_l".*>.*<span class="alt">(.+)<\/span>.*<\/li>/isU';
		if(preg_match($strPatternContent, $re, $matchesContent)) {
			$arrResults['content'] = trim($matchesContent[1]);
		}
		//http://img.v163.56.com/images/26/7/lyz05021113i56olo56i56.com_sc_mp4_126105926192.jpg
		$arrResults['extra']['video_pic'] = 'http://img.' . $arrVideoInfo['img_host'] . '/images/'
											. $arrVideoInfo['pURL'] . '/' . $arrVideoInfo['sURL'] . '/'
											. $arrVideoInfo['user'] . 'i56olo56i56.com_' 
											. $arrVideoInfo['URLid'] . '.jpg';

		//http://www.56.com/n_v163_/c46_/26_/7_/lyz05021113_/sc_mp4_126105926192_/1986000_/0_/48346574.swf
		$strSwf = 	"http://www.56.com/n_" . str_replace(array('.56.com', ':88'), '', $arrVideoInfo['img_host'])
					. "_/" . str_replace('.56.com', '', $arrVideoInfo['host']) . "_/"
					. $arrVideoInfo['pURL'] . "_/" . $arrVideoInfo['sURL'] . "_/" . $arrVideoInfo['user'] . "_/"
					. $arrVideoInfo['URLid'] . "_/" . $arrVideoInfo['totaltimes'] . "_/" . $arrVideoInfo['effectID']
					. "_/" . $arrVideoInfo['flvid'] . ".swf";
		$arrResults['extra']['video_swf'] = $strSwf;
		//$arrResults['extra']['video_player'] = $this->_formatFlashEmbed($strSwf, 480, 395);
		return $arrResults;
	}
	
	//56视频API
	private static function _spiderFor56Api($url, $arrUrlMatches, &$error) {
		$spiderUrl = 'http://v.56.com/API/vInfo.php?url='.$url;
		$re = '';
		$bol = HPCurl::call($spiderUrl, $re);
		if(!$bol) {
			$error = 'Curl error';
			return false;
		}
		
		$result = simplexml_load_string($re, 'SimpleXMLElement', LIBXML_NOCDATA);
		if(false === $result){
			$error = 'xml load err'.$re;
			return false;
		}
		
		if(-1 == intval($result->result['type'])) {
			$error = 'xml parser err';
			return false;
		}
		$results = get_object_vars($result->result);
		
		$arrResults = array();
		$arrResults['title'] = trim(mb_convert_encoding($results['title'], 'GB2312', 'UTF-8'));
		$arrResults['content'] = trim(mb_convert_encoding($results['desc'], 'GB2312', 'UTF-8'));
		$arrResults['extra']['video_pic'] = trim($results['coverurl']);
		$arrResults['extra']['video_swf'] = trim($results['flash']);
		return $arrResults;
	}
	
    //爱西柚视频API
	private static function _spiderForXiyouApi($url, $arrUrlMatches, &$error) {
		$spiderUrl = 'http://xiyou.cntv.cn/api.php?act=getvideo&pid=100&url='.$url.'&format=xml';
		//$spiderUrl = 'http://db-forum-test10.vm.baidu.com:8880/aixiyou.html';
                $re = '';
		$bol = HPCurl::call($spiderUrl, $re);
		if(!$bol) {
			$error = 'Curl error';
			return false;
		}
		$result = simplexml_load_string($re, 'SimpleXMLElement', LIBXML_NOCDATA);
		if(false === $result){
			$error = 'xml load err'.$re;
			return false;
		}
		if(-1 == intval($result->result['type'])) {
   		        $error = 'xml parser err';
			return false;
		}
		$results = get_object_vars($result->result);
		
		$arrResults = array();
		$arrResults['title'] = trim(mb_convert_encoding($results['title'], 'GB2312', 'UTF-8'));
		$arrResults['extra']['video_pic'] = trim($results['coverurl']);
		$arrResults['extra']['video_swf'] = trim($results['flash']);
		return $arrResults;
	}
	
    //土豆视频API
	private static function _spiderForTudou($url, $arrUrlMatches, &$error) {
		$spiderUrl = 'http://api.tudou.com/v3/gw?method=repaste.info.get&appKey=myKey&format=xml&url='.$url;
		//$spiderUrl = 'http://db-forum-test10.vm.baidu.com:8880/tudoustatic.html';
                $re = '';
		$bol = HPCurl::call($spiderUrl, $re);
		if(!$bol) {
			$error = 'Curl error';
			return false;
		}
		
		$result = simplexml_load_string($re, 'SimpleXMLElement', LIBXML_NOCDATA);
		if(false === $result){
			$error = 'xml load err'.$re;
			return false;
		}
		$results = get_object_vars($result->itemInfo);
		
		$arrResults = array();
		$arrResults['title'] = trim(mb_convert_encoding($results['title'], 'GB2312', 'UTF-8'));
		$arrResults['extra']['video_pic'] = trim($results['picUrl']);
		$arrResults['extra']['video_swf'] = trim($results['outerPlayerUrl']);
		return $arrResults;
	}
	
	//Youku视频API 现有两种URL 单视频模式v_show 列表模式v_playlist
	private static function _spiderForYoukuApi($url, $arrUrlMatches, &$error) {
		$spiderUrl = 'http://api.youku.com/api_ptvideoinfo?pid=XMTYyNA==&id='.$url;
		$re = '';
		$bol = HPCurl::call($spiderUrl, $re);
		if(!$bol) {
			$error = 'Curl error';
			return false;
		}
		
		$result = simplexml_load_string($re, 'SimpleXMLElement', LIBXML_NOCDATA);
		
		if(false === $result || 'fail' === (string)($result->item['status'])) {
			$error = 'xml load err'.$re;
			return false;
		}
		
		$results = get_object_vars($result->item);
		
		$arrResults = array();

		$arrResults['title'] = trim(mb_convert_encoding($results['title'], 'GB2312', 'UTF-8'));
		
		if(!is_object($results['comment'])) {
			$arrResults['content'] = trim(mb_convert_encoding($results['comment'], 'GB2312', 'UTF-8'));
		}
		
		$arrResults['extra']['video_pic'] = trim($results['imagelink']);
		$arrResults['extra']['video_swf'] = trim($results['playswf']);
		return $arrResults;
	}
	
	
	//Youku视频API 现有两种URL 单视频模式v_show 列表模式v_playlist
	private static function _spiderForPomohoApi($url, $arrUrlMatches, &$error) {
		$spiderUrl = 'http://video.pomoho.com/do/interfaces/gettiebaxml.aspx?url='.$url;
		$re = '';
		$bol = HPCurl::call($spiderUrl, $re);
		if(!$bol) {
			$error = 'Curl error';
			return false;
		}
		
		$result = simplexml_load_string($re, 'SimpleXMLElement', LIBXML_NOCDATA);
		
		if(false === $result) {
			$error = 'xml load err'.$re;
			return false;
		}
		
		$results = get_object_vars($result->item);
		
		if(!isset($results['title']) || !isset($results['playswf']) || !isset($results['imagelink'])) {
			$error = 'xml parser err';
			return false;
		}
		
		$arrResults = array();

		$arrResults['title'] = trim(mb_convert_encoding($results['title'], 'GB2312', 'UTF-8'));
		
		if(!is_object($results['comment'])) {
			$arrResults['content'] = trim(mb_convert_encoding($results['comment'], 'GB2312', 'UTF-8'));
		}
		
		$arrResults['extra']['video_pic'] = trim($results['imagelink']);
		$arrResults['extra']['video_swf'] = trim($results['playswf']);
		return $arrResults;
	}
	
	//酷6视频API
	private static function _spiderForKu6Api($url, $arrUrlMatches, &$error) {
		$strKu6ID = trim($arrUrlMatches[1]);
		
		if(empty($strKu6ID)) {
			$error = 'get ku6ID err';
			return false;
		}
		
		$spiderUrl = 'http://v.ku6.com/openapi/repaste.htm?t=fetchVideoInfo&pid=hoANreWVZblYgXaRoC5Z3A28iXYBr4GY8ZUD-qz00RKFLgtAPzJYO6wdz4pMPCLhKC2XzIxnOap0vv_H&id=' . $strKu6ID;
		
		$re = '';
		$bol = HPCurl::call($spiderUrl, $re);
		if(!$bol) {
			$error = 'Curl error';
			return false;
		}
		
		$result = simplexml_load_string($re, 'SimpleXMLElement', LIBXML_NOCDATA);
		if(false === $result) {
			$error = 'xml load err'.$re;
			return false;
		}
		
		if(-1 == intval($result->result['type'])) {
			$error = 'xml parser err';
			return false;
		}
		$results = get_object_vars($result->result);
		
		$arrResults = array();
		$arrResults['title'] = trim(mb_convert_encoding($results['title'], 'GB2312', 'UTF-8'));
		$arrResults['content'] = trim(mb_convert_encoding($results['desc'], 'GB2312', 'UTF-8'));
		$arrResults['extra']['video_pic'] = trim($results['picPath']);
		$arrResults['extra']['video_swf'] = trim($results['playswf']);
		return $arrResults;
	}
	
	//奇艺视频API
	private static function _spiderForQiyiApi($url, $arrUrlMatches, &$error) {
		$spiderUrl = 'http://player.share.qiyi.com/f/s/b.html?url='.$url;
		
		$re = '';
		$bol = HPCurl::call($spiderUrl, $re);
		if(!$bol) {
			$error = 'Curl error';
			return false;
		}
		
		$result = simplexml_load_string($re, 'SimpleXMLElement', LIBXML_NOCDATA);
		if(false === $result) {
			$error = 'xml load err'.$re;
			return false;
		}	
		
		$results = get_object_vars($result->result);
	    $strFlash = trim($results['flash']);
        if(empty($strFlash)) {
        	$error = 'xml parser err';
            return false;
        }
		
		$arrResults = array();
		$arrResults['title'] = trim(mb_convert_encoding($results['title'], 'GB2312', 'UTF-8'));
		$arrResults['extra']['video_pic'] = trim($results['coverurl']);
		$arrResults['extra']['video_swf'] = $strFlash;
		return $arrResults;
	}
	
    //乐视视频API
	private static function _spiderForLeTVApi($url, $arrUrlMatches, &$error) {
		$spiderUrl = 'http://app.letv.com/api/share_baidu_video.php?url='.$url;
		$re = '';
		$bol = HPCurl::call($spiderUrl, $re);
		if(!$bol) {
			$error = 'Curl error';
			return false;
		}
		
		$result = simplexml_load_string($re, 'SimpleXMLElement', LIBXML_NOCDATA);
		if(false === $result) {
			$error = 'xml load err'.$re;
			return false;
		}
		
		if(-1 == intval($result->result['type'])) {
			$error = 'xml parser err';
			return false;
		}
		$results = get_object_vars($result->result);
		
		$arrResults = array();
		$arrResults['title'] = trim(mb_convert_encoding($results['title'], 'GB2312', 'UTF-8'));
		$arrResults['content'] = trim(mb_convert_encoding($results['desc'], 'GB2312', 'UTF-8'));
		$arrResults['extra']['video_pic'] = trim($results['coverurl']);
		$arrResults['extra']['video_swf'] = trim($results['flash']);
		return $arrResults;
	}
	
	//激动网API
	private static function _spiderForJoyApi($url, $arrUrlMatches, &$error) {
		$spiderUrl = 'http://news.joy.cn/api/share.htm?url='.$url;
		$re = '';
		$bol = HPCurl::call($spiderUrl, $re);
		if(!$bol) {
			$error = 'Curl error';
			return false;
		}
		
		$result = simplexml_load_string($re, 'SimpleXMLElement', LIBXML_NOCDATA);
		if(false === $result) {
			$error = 'xml load err'.$re;
			return false;
		}
		
		if(-1 == intval($result->result['type'])) {
			$error = 'xml parser err';
			return false;
		}
		$results = get_object_vars($result->result);
		
		$arrResults = array();
		$arrResults['title'] = trim(mb_convert_encoding($results['title'], 'GB2312', 'UTF-8'));
		$arrResults['content'] = trim(mb_convert_encoding($results['desc'], 'GB2312', 'UTF-8'));
		$arrResults['extra']['video_pic'] = trim(mb_convert_encoding($results['coverurl'], 'GB2312', 'UTF-8'));
		$arrResults['extra']['video_swf'] = trim($results['flash']);
		return $arrResults;
	}
	
	//爱布谷API
	private static function _spiderForBuguApi($url, $arrUrlMatches, &$error) {
		$spiderUrl = 'http://share.apps.cntv.cn/ShareToKaiXin/zhuantietobaidukongjian.jsp?url='.$url;
		$re = '';
		$bol = HPCurl::call($spiderUrl, $re);
		if(!$bol) {
			$error = 'Curl error';
			return false;
		}
		echo($re);
	  $xml_parser = xml_parser_create(); 
	  if(!xml_parse($xml_parser,$str,true)){ 
		              xml_parser_free($xml_parser); 
		echo(00000);
					              return false; 
	  }
		$result = simplexml_load_string($re, 'SimpleXMLElement', LIBXML_NOCDATA);
		if(false === $result) {
			$error = 'xml load err'.$re;
			return false;
		}
		
		if(-1 == intval($result->result['type'])) {
			$error = 'xml parser err';
			return false;
		}
		$results = get_object_vars($result->result);
		
		$arrResults = array();
		$arrResults['title'] = trim(mb_convert_encoding($results['title'], 'GB2312', 'UTF-8'));
		$arrResults['content'] = trim(mb_convert_encoding($results['desc'], 'GB2312', 'UTF-8'));
		$arrResults['extra']['video_pic'] = trim($results['coverurl']);
		$arrResults['extra']['video_swf'] = trim($results['flash']);
		return $arrResults;
	}
	
	/**
	 * @brief 华录坞视频，已经支持自动播放
	 */
	private static function _spiderForHualu5Api($url, $arrUrlMatches, &$error) {
		$spiderUrl = 'http://power.hualu5.com/flash/share/baidu?url='.$url;
		$re = '';
		$bol = HPCurl::call($spiderUrl, $re);
		if(!$bol) {
			$error = 'Curl error';
			return false;
		}
		
		$result = simplexml_load_string($re, 'SimpleXMLElement', LIBXML_NOCDATA);
		if(false === $result) {
			$error = 'xml load err'.$re;
			return false;
		}
		if(-1 == intval($result->result['type'])) {
			$error = 'xml parser err';
			return false;
		}
		$results = get_object_vars($result->result);
		$arrResults = array();
		$arrResults['title'] = trim(mb_convert_encoding($results['title'], 'GB2312', 'UTF-8'));
		$arrResults['content'] = trim(mb_convert_encoding($results['desc'], 'GB2312', 'UTF-8'));
		$arrResults['extra']['video_pic'] = trim($results['coverurl']);
		$arrResults['extra']['video_swf'] = trim($results['flash']);
		$arrResults['extra']['video_swf_autoplay'] = $arrResults['extra']['video_swf'] . '&autoPlay=1';
		return $arrResults;
    }
    /*
     *@brief 新浪视频
     * */
    private static function _spiderForSinaApi($url, $arrUrlMatches, &$error) {
        $url_tmp = urlencode($url);
		$spiderUrl = 'http://video.sina.com.cn/api/getVideoInfo.php?url='.$url_tmp;
		$re = '';
		$bol = HPCurl::call($spiderUrl, $re);
		if(!$bol) {
			$error = 'Curl error';
			return false;
		}
		
        $result = json_decode($re, true);
		if(false == $result) {
			$error = 'xml load err:result='.$result.'re='.$re;
			return false;
		}
		if(0 == intval($result['result'])) {
			$error = 'xml parser err';
			return false;
		}
		$arrResults = array();
		$arrResults['title'] = trim(mb_convert_encoding($result['title'], 'GB2312', 'UTF-8'));
		$arrResults['content'] = trim(mb_convert_encoding($result['desc'], 'GB2312', 'UTF-8'));
		$arrResults['extra']['video_pic'] = trim($result['imagelink']);
		$arrResults['extra']['video_swf'] = 'http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid='.trim($result['vid']).'_/s.swf';
		return $arrResults;
	}
    /*
     *@brief 搜狐视频，支持自动播放
     * */
	private static function _spiderForSohuApi($url, $arrUrlMatches, &$error) {
		$spiderUrl = 'http://share.vrs.sohu.com/Video_Share.action?autoplay=false&url='.$url;
		$re = '';
		$bol = HPCurl::call($spiderUrl, $re);
		if(!$bol) {
			$error = 'Curl error';
			return false;
		}
		
		$result = simplexml_load_string($re, 'SimpleXMLElement', LIBXML_NOCDATA);
		if(false === $result) {
			$error = 'xml load err'.$re;
			return false;
		}
		if(-1 == intval($result->result['type'])) {
			$error = 'xml parser err';
			return false;
		}
		$results = get_object_vars($result->result);
		$arrResults = array();
		$arrResults['title'] = trim(mb_convert_encoding($results['title'], 'GB2312', 'UTF-8'));
		$arrResults['content'] = trim(mb_convert_encoding($results['desc'], 'GB2312', 'UTF-8'));
		$arrResults['extra']['video_pic'] = trim($results['coverurl']);
		$arrResults['extra']['video_swf'] = trim($results['flash']);
		$arrResults['extra']['video_swf_autoplay'] = $arrResults['extra']['video_swf'] . '&autoPlay=1';
		return $arrResults;
	}
}

?>
