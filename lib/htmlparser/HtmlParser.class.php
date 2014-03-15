<?php

/**
 * 
 * ˵����
 * �ڲ���װ��2�����߼���
 * 1. ��Ƶ���ݣ���������ַ������ͼ��ַ���Ľ���������RegularParser��
 * 2. ��ͨ��ҳ���ݵĽ�����
 * 
 */
include_once(dirname(__FILE__).'/HPDef.class.php');
include_once(dirname(__FILE__).'/HPCurl.class.php');
include_once(dirname(__FILE__).'/RegularParser.class.php');

Class HtmlParser {
	/**
	 * @var string Ҫ������url
	 */
	private $_url;
	
	/**
	 * @var string ������Ϣ
	 */
	private $_error;
	
	/**
	 * @brief ���캯��
	 * @param long $curlTimeoutMs �ڲ�curl�ĳ�ʱ
	 * @param long $curlRetry �ڲ�curl������
	 */
	public function __construct($url = '') {
		$this->_url = trim($url);
		$this->_error = "";
	}
	
	public function getError() {
		return $this->_error;
	}
	
	/**
	 * @brief ����Ҫ������url
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
	 * @brief �����ڲ�curl�ĳ�ʱ
	 * @param long $curlTimeoutMs
	 */
	public function setCurlTimeoutMs($curlTimeoutMs) {
		HPCurl::setTimeout($curlTimeoutMs);
	}
	/**
	 * @brief �����ڲ�curl������
	 * @param long $curlRetry
	 */
	public function setCurlRetry($curlRetry) {
		HPCurl::setRetry($curlRetry);
	}
	/******  curl config  end     ******/ 


	/******  html parser  begin   ******/
	/**
	 * @brief ������ͨҳ��
	 *   ����Ŀǰpmû�������ʽ�����ݽ������������������Ҫ��������demoչʾ�������dump��������
	 * @param array $results
	 * @param $nolyTitle ��ʾhtmlparser.so���Ƿ�ֻ����title
	 * �������ݸ�ʽ��
	 *   'title' => '����',
	 *   'content' => '����',
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
	 * @brief ��Ƶҳ�����
	 * @param array $results
	 * �������ݸ�ʽ��
	 *   'title' => '����',
	 *   'content' => '����',
	 *   'extra' => array(
	 *       'video_pic' => '����ͼ��ַ',
	 *       'video_swf' => '��Ƶflash��ַ',
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

	/*��ʽ����Ƶ����*/
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