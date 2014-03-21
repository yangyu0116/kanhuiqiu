<?php
/**
 * @brief HtmlParser内部使用的curl的包装
 * @author Administrator
 */
class HPCurl {
	// ms
	private static $_timeout = 500;
	// 1 表示重试1次，即总共最多2次；0表示不重试；
	private static $_retry = 1;
	
	/**
	 * @brief 设置超时
	 * @param long $intTimeoutMs
	 */
	public static function setTimeout($intTimeoutMs) {
		self::$_timeout = $intTimeoutMs;
	}
	public static function getTimeout() {
		return self::$_timeout;
	}
	/**
	 * @brief 设置重试
	 * @param long $intRetry
	 */
	public static function setRetry($intRetry) {
		self::$_retry = $intRetry;
	}
	public static function getRetry() {
		return self::$_retry;
	}
	/**
	 * @brief 发起curl调用
	 * @param string $url
	 * @param string & $res 用于返回结果
	 * @return succ:true, fail:false
	 */
	public static function call($url, & $res) {
		$curl = curl_init();
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		}
		// 少量网站不设置这个会出错
		curl_setopt($curl, CURLOPT_ENCODING, 'gzip, deflate');
		// 少量网站需要做跳转
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_NOSIGNAL, 1);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT_MS, self::$_timeout);
		curl_setopt($curl, CURLOPT_TIMEOUT_MS, self::$_timeout);
		curl_setopt($curl, CURLOPT_URL, $url);
		
		$retry = self::$_retry + 1;
		$succ = false;
		while ($retry--) { // TODO
			$res = curl_exec($curl);
			if ($res) {
				$succ = true;
				break;
			}
		}
		curl_close($curl);
		return $succ;
	}
}
?>
