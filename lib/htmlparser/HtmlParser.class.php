<?php

/**
 * 
 * 说明：
 * 内部封装了2部分逻辑：
 * 1. 视频内容（播放器地址，缩略图地址）的解析，调用RegularParser；
 * 2. 普通网页内容的解析；
 * 
 */
include_once(dirname(__FILE__).'/HPDef.class.php');
include_once(dirname(__FILE__).'/HPCurl.class.php');
include_once(dirname(__FILE__).'/RegularParser.class.php');

Class HtmlParser {
	/**
	 * @var string 要解析的url
	 */
	private $_url;
	
	/**
	 * @var string 错误信息
	 */
	private $_error;
	
	/**
	 * @brief 构造函数
	 * @param long $curlTimeoutMs 内部curl的超时
	 * @param long $curlRetry 内部curl的重试
	 */
	public function __construct($url = '') {
		$this->_url = trim($url);
		$this->_error = "";
	}
	
	public function getError() {
		return $this->_error;
	}
	
	/**
	 * @brief 设置要解析的url
	 * @param string $url
	 */
	public function setUrl($url) {
		$this->_url = trim($url);
	}

	public function parser(& $results) {
		$results = array();
		
		// parser regular
		$bol = RegularParser::parser($this->_url, $results);
		if ($bol === true) {
			return true;
		}
		
		// parser html
		$bol = $this->htmlParser($results);
		return $bol;
	}


	/******  curl config  begin   ******/ 
	/**
	 * @brief 设置内部curl的超时
	 * @param long $curlTimeoutMs
	 */
	public function setCurlTimeoutMs($curlTimeoutMs) {
		HPCurl::setTimeout($curlTimeoutMs);
	}
	/**
	 * @brief 设置内部curl的重试
	 * @param long $curlRetry
	 */
	public function setCurlRetry($curlRetry) {
		HPCurl::setRetry($curlRetry);
	}
	/******  curl config  end     ******/ 


	/******  html parser  begin   ******/
	/**
	 * @brief 解析普通页面
	 *   由于目前pm没有提出正式的内容解析需求，这里的内容主要还是用于demo展示，具体可dump出来看看
	 * @param array $results
	 * @param $nolyTitle 表示htmlparser.so中是否只解析title
	 * 返回数据格式：
	 *   'title' => '标题',
	 *   'content' => '内容',
	 */
	public function htmlParser(& $results, $nolyTitle = false) {	
		$re = '';
		$bol = HPCurl::call($this->_url, $re);
		if(!$bol) {
			$this->_error = sprintf("IN[URL:%s] CURL[timeout:%d retry:%d] FAIL", $this->_url, HPCurl::getTimeout(), HPCurl::getRetry());
			return false;
		}
		
		if ($nolyTitle) {
			$results = htmlparser_title($this->_url, $re);
		} else {
			$results = htmlparser($this->_url, $re, 0);	
		}
		if ($results === false) {
			$this->_error = sprintf("IN[URL:%s LEN:%d] call htmlparser.so fail", $this->_url, strlen($re));
			return false;
		}
		$title = '';
		if (strlen(trim($results['real_title'])) > 0) {
			$title = $results['real_title'];
		} else {
			$title = $results['html_title'];
		}
		$results['title'] = $title;
		$results['url'] = $this->_url;
		return true;
	}
	/******  html parser  end     ******/ 

	
	/****** regular parser  begin ******/ 
	/**
	 * @brief 视频页面解析
	 * @param array $results
	 * 返回数据格式：
	 *   'title' => '标题',
	 *   'content' => '内容',
	 *   'extra' => array(
	 *       'video_pic' => '缩略图地址',
	 *       'video_swf' => '视频flash地址',
	 */
	public function regularParser(& $results) {
		$res = RegularParser::parser($this->_url, $results);
		if ($res !== true) {
			$this->_error = $res === RegularParser::ERROR_NO_MATCH ? "" : $res;
			return false;
		}
		return true;
	}
	/****** regular parser  begin ******/ 

	/*格式化视频内容*/
	public function formatFlashEmbed($strSrc, $intWidth = 480 , $intHeight = 400) {
		return '<object id="video_'.rand(0, 1000).'" width="'.$intWidth.'" height="'.$intHeight.'" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
				<param name="movie" value="'.$strSrc.'"></param>
				<param name="allowFullScreen" value="true"></param>
				<param name="allowscriptaccess" value="always"></param>
				<embed src="'.$strSrc.'" quality="high" width="'.$intWidth.'" height="'.$intHeight.'" align="middle" allowScriptAccess="always" allowfullscreen="true" type="application/x-shockwave-flash" mode="transparent"></embed>
				</object>';
	}
	

}

?>