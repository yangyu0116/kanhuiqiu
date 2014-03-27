<?php
/**
 * @abstract http请求类
 */
class DBHttpProxy
{
	const CONNECT_TIMEOUT = 1000;//连接超时时间，单位ms，利用curl时不能小于1000
	const TIMEOUT = 1000;//交互超时时间，单位ms
	/**
	 * GET请求
	 *
	 * @param string $url 请求的url
	 * @param bool $isHttps 是否是https
	 * @return string 返回运行结果
	 */
	public static function get($url, $isHttps = false)
	{
		return self::request($url, array(), 'GET', $isHttps);
	}
	/**
	 * POST请求
	 *
	 * @param string $url 请求的url
	 * @param array $data 请求传输的数据
	 * @param bool $isHttps 是否是https
	 * @return string 返回运行结果
	 */
	public static function post($url, $data, $isHttps = false)
	{
		return self::request($url, $data, 'POST', $isHttps);
	}
	/**
	 * request请求（GET || POST）
	 *
	 * @param string $url 请求的url
	 * @param array $data 请求传输的数据
	 * @param string $method 请求的方法：GET || POST
	 * @param bool $isHttps 是否是https
	 * @return string 返回运行结果
	 */
	public static function request($url, $data = array(), $method  = 'GET', $isHttps = false, $cookie = NULL)
	{
		$ch = curl_init();
        $curlOptions = array(
            CURLOPT_URL				=>	$url,
            CURLOPT_CONNECTTIMEOUT	=>	intval(self::CONNECT_TIMEOUT/1000),
            CURLOPT_TIMEOUT			=>	intval(self::TIMEOUT/1000),
            CURLOPT_RETURNTRANSFER	=>	true,
            CURLOPT_HEADER			=>	false,
            CURLOPT_FOLLOWLOCATION	=>	true,
            CURLOPT_USERAGENT => 'videoapi',
        );
        if('POST' === $method)
        {
        	$curlOptions[CURLOPT_POST] = true;
        	$curlOptions[CURLOPT_POSTFIELDS] = http_build_query($data);
        }
        if(true === $isHttps)
        {
        	$curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
        }
		if(isset($cookie))
		{
			$curlOptions[CURLOPT_COOKIE] = $cookie;
		}
        curl_setopt_array($ch, $curlOptions);
        $response = curl_exec($ch);
        $errno = curl_errno($ch);
        if(0 != $errno)
        {
            CLogger::fatal("httpproxy_connect_fail:$errno $url", 'dal');
        	return false;
        }
        curl_close($ch);
        return $response;
	}
}
?>
