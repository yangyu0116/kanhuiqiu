<?php
/**
 * @brief HtmlParser�ڲ�ʹ�õ�curl�İ�װ
 * @author Administrator
 */
class HPCurl {
	// ms
	private static $_timeout = 500;
	// 1 ��ʾ����1�Σ����ܹ����2�Σ�0��ʾ�����ԣ�
	private static $_retry = 1;
	
	/**
	 * @brief ���ó�ʱ
	 * @param long $intTimeoutMs
	 */
	public static function setTimeout($intTimeoutMs) {
		self::$_timeout = $intTimeoutMs;
	}
	public static function getTimeout() {
		return self::$_timeout;
	}
	/**
	 * @brief ��������
	 * @param long $intRetry
	 */
	public static function setRetry($intRetry) {
		self::$_retry = $intRetry;
	}
	public static function getRetry() {
		return self::$_retry;
	}
	/**
	 * @brief ����curl����
	 * @param string $url
	 * @param string & $res ���ڷ��ؽ��
	 * @return succ:true, fail:false
	 */
	public static function call($url, & $res) {
		$curl = curl_init();
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		}
		// ������վ��������������
		curl_setopt($curl, CURLOPT_ENCODING, 'gzip, deflate');
		// ������վ��Ҫ����ת
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
