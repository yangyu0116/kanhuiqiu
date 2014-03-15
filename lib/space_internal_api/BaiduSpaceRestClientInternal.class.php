<?php
/***************************************************************************
 * 
 * Copyright (c) 2008 Baidu.com, Inc. All Rights Reserved
 * $Id: BaiduSpaceRestClientInternal.class.php,v 1.1 2010/03/18 09:06:36 mahongxu Exp $ 
 * 
 **************************************************************************/
 
 
 
/**
 * @file BaiduSpaceRestClientInternal.class.php
 * @author zhujt(zhujianting@baidu.com)
 * @date 2008/10/24 15:46:37
 * @version $Revision: 1.1 $ 
 * @brief 
 *  
 **/

require_once('BaiduSpaceAPIErrorCodes.inc.php');

class BaiduSpaceRestClientInternal
{
	public $api_key;
	public $app_secret;
	public $bduss;
	public $uid;
	public $uname;

	public $last_call_id;
	public $batch_mode;

	public $batch_queue;
	private $final_encode;	//最终返回数据的编码格式
	private $server_addr;	//api服务的地址

	const BATCH_MODE_DEFAULT = 0;
	const BATCH_MODE_SERVER_PARALLEL = 0;
	const BATCH_MODE_SERIAL_ONLY = 2;

	/**
	 * Create the client.
	 */
	public function __construct($uid, $uname, $bduss = null, $final_encode = 'GBK')
	{
		$this->api_key		= LibBaiduSpaceRestClientInternalConfig::API_KEY;
		$this->app_secret	= LibBaiduSpaceRestClientInternalConfig::SECRET_KEY;
		$this->bduss		= $bduss;
		$this->uid			= $uid;
		$this->uname		= $uname;

		$this->batch_mode	= self::BATCH_MODE_DEFAULT;
		$this->last_call_id	= 0;
		$this->final_encode	= $final_encode;
		$this->server_addr = LibBaiduSpaceRestClientInternalConfig::BDSPACE_API_REST_SERVER;
	}

	/**
	 * @brief Start a batch operation.
	 *
	 * @return  
	 * @retval   
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/04/30 13:14:53
	**/
	public function begin_batch()
	{
		if( $this->batch_queue !== null )
		{
			throw new BaiduSpaceRestClientException(API_EC_BATCH_ALREADY_STARTED);
		}
		$this->batch_queue = array();
	}

	/**
	 * @brief End current batch operation
	 *
	 * @return  public function 
	 * @retval   
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/04/30 13:15:13
	**/
	public function end_batch($format = 'xml')
	{
		if( $this->batch_queue === null )
		{
			throw new BaiduSpaceRestClientException(API_EC_BATCH_NOT_STARTED);
		}
		$this->execute_server_side_batch($format);
		$this->batch_queue = null;
	}

	/**
	 * @brief excute batch operation.
	 *
	 * @return
	 * @retval   
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/04/30 13:15:36
	**/
	private function execute_server_side_batch($format)
	{
		$num = count($this->batch_queue);
		$method_feed = array();
		foreach( $this->batch_queue as $batch_item )
		{
			$method_feed[] = $this->create_post_string($batch_item['m'], $batch_item['p']);
		}

		$method_feed_json = json_encode($method_feed);

		$serial_only = ($this->batch_mode == self::BATCH_MODE_SERIAL_ONLY);
		$params = array('method_feed' => $method_feed_json,
						'serial_only' => $serial_only,
						'format' => $format);

		$result = $this->post_request('batch.run', $params);
		if( $result == false )
		{
			throw new BaiduSpaceRestClientException(API_EC_SERVICE);
		}
		$format = isset($params['format']) ? $params['format'] : null;
		if( strcasecmp($format, 'xml') === 0 )
		{
			$result = $this->convert_xml_to_result($result);
		}
		else
		{
			$result = $this->convert_json_to_result($result);
		}

		if( is_array($result) && isset($result['error_code']) )
		{
			throw new BaiduSpaceRestClientException($result['error_code'], $result['error_msg']);
		}

		for( $i = 0; $i < $num; $i++ )
		{
			$item = $this->batch_queue[$i];
			$item_result = $result[$i];
			$format = isset($item['p']['format']) ? $item['p']['format'] : null;
			if( strcasecmp($format, 'xml') === 0 )
			{
				$item_result = $this->convert_xml_to_result($item_result, $this->final_encode);
			}
			else
			{
				$item_result = $this->convert_json_to_result($item_result, $this->final_encode);
			}

			if( is_array($item_result) && isset($item_result['error_code']) )
			{
				throw new BaiduSpaceRestClientException($item_result['error_code'], $item_result['error_msg']);
			}
			$item['r'] = $item_result;
		}
	}

	public function & users($method, $array = array())
	{
		$params = array();
		switch( $method )
		{
			case 'getLoggedInUser':	
				break;

			case 'getInfo':
				if( isset($array['uids']) )
				{
					$params['uids'] = $array['uids'];
				}
				else
				{
					$params['uids'] = $this->uid;
				}
				if( isset($array['fields']) )
				{
					$params['fields'] = $array['fields'];
				}
				break;

			case 'isAppAdded':
				if( isset($array['appid']) )
				{
					$params['appid'] = $array['appid'];
				}
				else
				{
					throw new BaiduSpaceRestClientException(API_EC_PARAM);
				}
				if( isset($array['uid']) )
				{
					$params['uid'] = $array['uid'];
				}
				break;

			default:
				throw new BaiduSpaceRestClientException(API_EC_METHOD);
				break;
		}

		$method = 'baidu.users.' . $method;
		if( isset($array['callback']) )
		{
			$params['callback'] = $array['callback'];
		}
		if( isset($array['format']) )
		{
			$params['format'] = $array['format'];
		}

		return $this->call_method($method, $params);
	}

	public function & space($method, $array = array())
	{
		$params = array();
		switch( $method )
		{
			case 'getInfo':
				if( isset($array['spaceurl']) )
				{
					$params['spaceurl'] = $array['spaceurl'];
				}
				if( isset($array['uid']) )
				{
					$params['uid'] = $array['uid'];
				}
				break;

			case 'getSpaceUserInfos':
				if( isset($array['uids']) )
				{
					$params['uids'] = $array['uids'];
				}
				break;

			default:
				throw new BaiduSpaceRestClientException(API_EC_METHOD);
				break;
		}

		$method = 'baidu.space.' . $method;
		if( isset($array['callback']) )
		{
			$params['callback'] = $array['callback'];
		}
		if( isset($array['format']) )
		{
			$params['format'] = $array['format'];
		}

		return $this->call_method($method, $params);
	}

	public function & friends($method, $array = array())
	{
		$params = array();
		switch( $method )
		{
			case 'getFriends':
				if( isset($array['uid']) )
				{
					$params['uid'] = $array['uid'];
				}
				if( isset($array['bidirectional']) )
				{
					$params['bidirectional'] = $array['bidirectional'];
				}
				break;

			case 'getFriendRelations':
				if( isset($array['uid']) )
				{
					$params['uid'] = $array['uid'];
				}
				break;

			case 'areFriends':
				if( isset($array['uids1']) && isset($array['uids2']) )
				{
					$params['uids1'] = $array['uids1'];
					$params['uids2'] = $array['uids2'];
				}
				else
				{
					throw new BaiduSpaceRestClientException(API_EC_PARAM);
				}
				break;

			case 'getAppUsers':
			case 'getNonAppUsers':
				if( isset($array['appid']) )
				{
					$params['appid'] = $array['appid'];
				}
				else
				{
					throw new BaiduSpaceRestClientException(API_EC_PARAM);
				}
				if( isset($array['bidirectional']) )
				{
					$params['bidirectional'] = $array['bidirectional'];
				}
				break;

			default:
				throw new BaiduSpaceRestClientException(API_EC_METHOD);
				break;
		}

		$method = 'baidu.friends.' . $method;
		if( isset($array['callback']) )
		{
			$params['callback'] = $array['callback'];
		}
		if( isset($array['format']) )
		{
			$params['format'] = $array['format'];
		}

		return $this->call_method($method, $params);
	}

	public function & notifications($method, $array = array())
	{
		$params = array();
		switch( $method )
		{
			case 'sendTemplatedNotification':
				if( isset($array['to_ids']) &&
					isset($array['template_id']) &&
					isset($array['body_data']) &&
					isset($array['appid']) )
				{
					$params['to_ids'] = $array['to_ids'];
					$params['template_id'] = $array['template_id'];
					$params['body_data'] = $array['body_data'];
					$params['appid'] = $array['appid'];
				}
				else
				{
					throw new BaiduSpaceRestClientException(API_EC_PARAM);
				}
				if( isset($array['resource_id']) )
				{
					$params['resource_id'] = $array['resource_id'];
				}
				if( isset($array['flag']) )
				{
					$params['flag'] = $array['flag'];
				}
				break;

			default:
				throw new BaiduSpaceRestClientException(API_EC_METHOD);
				break;
		}

		$method = 'baidu.notifications.' . $method;
		if( isset($array['callback']) )
		{
			$params['callback'] = $array['callback'];
		}
		if( isset($array['format']) )
		{
			$params['format'] = $array['format'];
		}

		return $this->call_method($method, $params);
	}

	public function & feed($method, $array = array())
	{
		$params = array();
		switch( $method )
		{
			case 'publishTemplatedAction':
				if( isset($array['template_id']) &&
					isset($array['title_data']) &&
					isset($array['appid']) )
				{
					$params['template_id'] = $array['template_id'];
					$params['title_data'] = $array['title_data'];
					$params['appid'] = $array['appid'];
				}
				else
				{
					throw new BaiduSpaceRestClientException(API_EC_PARAM);
				}
				if( isset($array['body_data']) )
				{
					$params['body_data'] = $array['body_data'];
				}
				if( isset($array['resource_id']) )
				{
					$params['resource_id'] = $array['resource_id'];
				}
				if( isset($array['owner_uid']) )
				{
					$params['owner_uid'] = $array['owner_uid'];
				}
				if( isset($array['grouptext']) )
				{
					$params['grouptext'] = $array['grouptext'];
				}
				if( isset($array['title']) )
				{
					$params['title'] = $array['title'];
				}
				if( isset($array['link']) )
				{
					$params['link'] = $array['link'];
				}
				break;

			default:
				throw new BaiduSpaceRestClientException(API_EC_METHOD);
				break;
		}

		$method = 'baidu.feed.' . $method;
		if( isset($array['callback']) )
		{
			$params['callback'] = $array['callback'];
		}
		if( isset($array['format']) )
		{
			$params['format'] = $array['format'];
		}

		return $this->call_method($method, $params);
	}

	/* UTILITY FUNCTIONS */

	/**
	 * @brief Implementation of the Call to the Open API
	 *
	 * @param string $method	name of the Open API, e.g. 'baidu.users.getInfo'
	 * @param array $params		parameters of the calling Open API, you can specify the 'format' and
	 *							'callback' parameter here to control the response data format and
	 *							content
	 * @return array 
	 * @retval
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/04/30 13:14:53
	**/
	public function & call_method($method, $params)
	{
		//Check if we are in batch mode
		if( $this->batch_queue === null )
		{
			$result = $this->post_request($method, $params);
			if( $result === false )
			{
				throw new BaiduSpaceRestClientException(API_EC_SERVICE);
			}
			$format = isset($params['format']) ? $params['format'] : null;
			if( strcasecmp($format, 'xml') === 0 )
			{
				$result = $this->convert_xml_to_result($result, $this->final_encode);
			}
			else
			{
				$result = $this->convert_json_to_result($result, $this->final_encode);
			}

			if( is_array($result) && isset($result['error_code']) )
			{
				throw new BaiduSpaceRestClientException($result['error_code'], $result['error_msg']);
			}
		}
		else
		{
			$result = null;
			$batch_item = array('m' => $method, 'p' => $params, 'r' => & $result);
			$this->batch_queue[] = $batch_item;
		}

		return $result;
	}

	/**
	 * @brief talk with open api rest server
	 *	create and post the http request to the rest server and get the reponse back.
	 *
	 * @param string $method	name of the Open API, e.g. 'baidu.users.getInfo'
	 * @param array $params		parameters of the calling Open API, you can specify the 'format' and
	 *							'callback' parameter here to control the response data format and
	 *							content
	 * @return array 
	 * @retval
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/04/30 13:14:53
	**/
	public function post_request($method, $params)
	{
		$post_string = $this->create_post_string($method, $params);
		$result = self::http_post_request($this->server_addr, $post_string);
		return $result;
	}

	/**
	 * @brief convert a json string into php array
	 *
	 * @param string $json	json format string to be convert
	 * @param string $final_encode	final encode of the result array
	 * @return array 
	 * @retval   
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/04/30 13:38:30
	**/
	public function convert_json_to_result($json, $final_encode = 'UTF-8')
	{
		$result = json_decode($json, true);
		if( strcasecmp($final_encode, 'UTF-8') !== 0 )
		{
			$result = self::iconv_recursive($result, 'UTF-8', $final_encode);
		}

		return $result;
	}

	/**
	 * @brief convert a xml string into php array
	 *
	 * @param string $xml xml format string to be convert
	 * @param string $final_encode	final encode of the result array
	 * @return array 
	 * @retval   
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/04/30 13:38:30
	**/
	public function convert_xml_to_result($xml, $final_encode = 'UTF-8')
	{
		$sxml = simplexml_load_string($xml);
		$result = self::convert_simplexml_to_array($sxml, $this->final_encode);
		return $result;
	}

	/**
	 * @brief convert simple xml object into php array
	 *
	 * @param string $sxml simple xml object
	 * @param string $final_encode	final encode of the result array
	 * @return array or string
	 * @retval   
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/04/30 13:38:30
	**/
	public static function convert_simplexml_to_array($sxml, $final_encode)
	{
		$arr = array();
		if( $sxml )
		{
			foreach( $sxml as $k => $v )
			{
				if( $sxml['list'] )
				{
					$arr[] = self::convert_simplexml_to_array($v, $final_encode);
				}
				else
				{
					$arr[$k] = self::convert_simplexml_to_array($v, $final_encode);
				}
			}
		}

		if( count($arr) > 0 )
		{
			return $arr;
		}
		else
		{
			if( strcasecmp($final_encode, 'UTF-8') !== 0 )
			{
				return iconv('UTF-8', $final_encode, $sxml);
			}
			else
			{
				return (string)$sxml;
			}
		}
	}

	/**
	 * @brief create a post string for an open api call.
	 *
	 * @param string $method	name of the api, e.g. 'baidu.users.getInfo'
	 * @param array $params		input parameters of the api call
	 * @param string $namespace	added prefix of every post param
	 * @return string
	 * @retval   
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/04/30 13:38:30
	**/
	private function create_post_string($method, $params, $namespace = 'bd_sig')
	{
		$params['method'] = $method;
		$params['bduss'] = $this->bduss;
		$params['api_key'] = $this->api_key;
		$params['user_id'] = $this->uid;
		$params['user_name'] = $this->uname;

		$params['call_id'] = microtime(true);
		if( $params['call_id'] <= $this->last_call_id )
		{
			$params['call_id'] = $this->last_call_id + 0.001;
		}
		$this->last_call_id = $params['call_id'];

		if( !isset($params['v']) )
		{
			$params['v'] = OPEN_API_SDK_VERSION;
		}

		$post_params = array();
		$post_string = '';

		foreach( $params as $key => $val )
		{
			if( $val === null )
			{
				continue;
			}
			if( is_array($val) )
			{
				$val = implode(',', $val);
			}
			$val = self::no_magic_quotes($val);
			if( strcasecmp($this->final_encode, 'GBK') !== 0 )
			{
				$val = iconv($this->final_encode, 'GBK', $val);
			}
			$post_params[$key] = $val;
		}
		$sig = self::generate_sig($post_params, $this->app_secret);

		foreach( $post_params as $key => $val )
		{
			$post_string .= $key . '=' . urlencode($val) . '&';
		}
		$post_string .= $namespace . '=' . $sig;

		return $post_string;
	}

	/**
	 * @brief do http post request to open api rest server 
	 *
	 * @param string $url	http interface of the rest server
	 * @param string $post_string	post string of the http post request
	 * @param int $connect_timeout	timeout of connect to rest server
	 * @param int $read_timeout		timeout of read response from rest server
	 * @return string
	 * @retval   
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/04/30 13:38:30
	**/
	public static function http_post_request($url, $post_string,
			$connect_timeout = LibBaiduSpaceRestClientInternalConfig::CONNECT_TIMEOUT,
			$timeout = LibBaiduSpaceRestClientInternalConfig::TIMEOUT)
	{
		$result = '';
		if( LibBaiduSpaceRestClientInternalConfig::USE_CURL && function_exists('curl_init') )
		{
			// Use CURL if installed...
			$user_agent = sprintf('Baidu Space Open API PHP%s Client %s (curl)', phpversion(), OPEN_API_SDK_VERSION);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $connect_timeout);
			curl_setopt($ch, CURLOPT_TIMEOUT_MS, $timeout);
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
			curl_setopt($ch, CURLOPT_POST, true);
			//curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
			$result = curl_exec($ch);
			curl_close($ch);
		}
		else
		{
			// Non-CURL based version...
			$result = self::socket_post_ex($url, $post_string, $connect_timeout, $timeout);

		}
		return $result;
	}

	/**
	 * @brief do http post request to open api rest server via stream context
	 *
	 * @param string $url	http interface of the rest server
	 * @param string $post_string	post string of the http post request
	 * @param int $connect_timeout	timeout of connect to rest server
	 * @param int $read_timeout		timeout of read response from rest server
	 * @return string
	 * @retval   
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/04/30 13:38:30
	**/
	public static function socket_post($url, $post_string, $connect_timeout, $timeout) 
	{
		$content_type = 'application/x-www-form-urlencoded';
		$user_agent = sprintf('Baidu Space Open API PHP%s Client %s (non-curl)', phpversion(), OPEN_API_SDK_VERSION);
		$context = array('http' => array('method' => 'POST',
										 'header' => 'Content-type:' . $content_type . '\r\n'.
													 'User-Agent:' . $user_agent . '\r\n'.
													 'Content-length:' . strlen($post_string) . '\r\n',
										 'content' => $post_string));
		$contextid = stream_context_create($context);
		$sock = fopen($url, 'r', false, $contextid);
		if( $sock )
		{
			$result = '';
			while( !feof($sock) )
			{
				$result .= fgets($sock, 4096);
			}
			fclose($sock);
		}

		return $result;
	}

	/**
	 * @brief do http post request to open api rest server via socket
	 *
	 * @param string $url	http interface of the rest server
	 * @param string $post_string	post string of the http post request
	 * @param int $connect_timeout	timeout of connect to rest server
	 * @param int $read_timeout		timeout of read response from rest server
	 * @return string
	 * @retval   
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/04/30 13:38:30
	**/
	public static function socket_post_ex($url, $post_string, $connect_timeout, $timeout)
	{
		$url_info = parse_url($url);
		$url_info['path'] = ($url_info['path'] == '' ? '/' : $url_info['path']);
		$url_info['port'] = ($url_info['port'] == '' ? 80 : $url_info['port']);
		$host_ip = gethostbyname($url_info['host']);

		$url_info['request'] =  $url_info['path'] . 
			(empty($url_info['query']) ? '' : '?' . $url_info['query']) . 
			(empty($url_info['fragment']) ? '' : '#' . $url_info['fragment']);

		$fsock = fsockopen($host_ip, $url_info['port'], $errno, $errstr, (float)$connect_timeout / 1000.0);
		if( false === $fsock ) {
			return false;
		}

		/* begin send data */
		$user_agent = sprintf('Baidu Space Open API PHP%s Client %s (non-curl)', phpversion(), OPEN_API_SDK_VERSION);
		$in = 'POST ' . $url_info['request'] . " HTTP/1.0\r\n";
		$in .= "Accept: */*\r\n";
		$in .= "User-Agent: $user_agent\r\n";
		if( $url_info['port'] == 80 ) {
			$in .= 'Host: ' . $url_info['host'] . "\r\n";
		}
		else {
			$in .= 'Host: ' . $url_info['host'] . ':' . $url_info['port'] . "\r\n";
		}
		$in .= "Content-type: application/x-www-form-urlencoded\r\n";
		$in .= 'Content-Length: ' . strlen($post_string) . "\r\n";
		$in .= "Connection: Close\r\n\r\n";
		$in .= "$post_string\r\n\r\n";


		stream_set_timeout($fsock, 0, $timeout);
		if( !fwrite($fsock, $in, strlen($in)) )
		{
			fclose($fsock);
			return false;
		}
		unset($in);

		/* process response */
		$out = '';
		while( !feof($fsock) )
		{
			$buff = fgets($fsock, 4096);
			$out .= $buff;
		}
		fclose($fsock);

		$pos = strpos($out, "\r\n\r\n");
		$head = substr($out, 0, $pos);
		$status = substr($head, 0, strpos($head, "\r\n"));
		$body = substr($out, $pos + 4, strlen($out) - ($pos + 4));
		if( preg_match('/^HTTP\/\d\.\d\s([\d]+)\s.*$/', $status, $matches) )
		{
			if( intval($matches[1]) / 100 == 2 )
			{
				return $body;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	/**
	 * @brief get url in baidu via subdomain
	 *
	 * @param string $subdomain
	 * @return string
	 * @retval   
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/04/30 13:38:30
	**/
	public static function get_baidu_url($subdomain = 'www')
	{
		return 'http://'. $subdomain . '.baidu.com';
	}

	/**
	 * @brief strip slashes of the input string
	 *
	 * @param string $val
	 * @return string
	 * @retval   
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/04/30 13:38:30
	**/
	public static function no_magic_quotes($val)
	{
		if( get_magic_quotes_gpc() )
		{
			return stripslashes($val);
		}
		else
		{
			return $val;
		}
	}

	/**
	 * @brief generate a signature for an array
	 *
	 * @param array $params			array to be signatured
	 * @param string $app_secret	secret key used to generate the signature
	 * @return string
	 * @retval md5 string
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/04/30 13:38:30
	**/
	public static function generate_sig($params, $app_secret)
	{
		$str = '';
		ksort($params);
		//Note: make sure that the signature parameter is not already included in $params.
		foreach( $params as $k => $v )
		{
			$str .= "$k=$v";
		}
		$str .= $app_secret;
		return md5($str);
	}

	/**
	 * @brief urlencode a variable recursively, array keys and object property names will not be
	 * encoded, so you would better use ASCII to define the array key name or object property name.
	 *
	 * @param [in] mixed $var
	 * @return  mixed, with the same variable type
	 * @retval   
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/06/01 14:33:21
	**/
	public static function urlencode_recursive($var)
	{
		if( is_array($var) )
		{
			$rvar = array();
			foreach( $var as $key => $val )
			{
				$rvar[$key] = self::urlencode_recursive($val);
			}
			return $rvar;
		}
		elseif( is_object($var) )
		{
			$rvar = null;
			foreach( $var as $key => $val )
			{
				$rvar->{$key} = self::urlencode_recursive($val);
			}
			return $rvar;
		}
		elseif( is_string($var) )
		{
			return urlencode($var);
		}
		else
		{
			return $var;
		}
	}

	/**
	 * @brief urldecode a variable recursively, array keys and object property names will not be
	 * decoded, so you would better use ASCII to define the array key name or object property name.
	 *
	 * @param [in] mixed $var
	 * @return  mixed, with the same variable type
	 * @retval   
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/06/03 11:32:33
	**/
	public static function urldecode_recursive($var)
	{
		if( is_array($var) )
		{
			$rvar = array();
			foreach( $var as $key => $val )
			{
				$rvar[$key] = self::urldecode_recursive($val);
			}
			return $rvar;
		}
		elseif( is_object($var) )
		{
			$rvar = null;
			foreach( $var as $key => $val )
			{
				$rvar->{$key} = self::urldecode_recursive($val);
			}
			return $rvar;
		}
		elseif( is_string($var) )
		{
			return urldecode($var);
		}
		else
		{
			return $var;
		}
	}

	/**
	 * @brief base64_encode a variable recursively, array keys and object property names will not be
	 * encoded, so you would better use ASCII to define the array key name or object property name.
	 *
	 * @param [in] mixed $var
	 * @return  mixed, with the same variable type
	 * @retval   
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/06/01 14:33:21
	**/
	public static function base64_encode_recursive($var)
	{
		if( is_array($var) )
		{
			$rvar = array();
			foreach( $var as $key => $val )
			{
				$rvar[$key] = self::base64_encode_recursive($val);
			}
			return $rvar;
		}
		elseif( is_object($var) )
		{
			$rvar = null;
			foreach( $var as $key => $val )
			{
				$rvar->{$key} = self::base64_encode_recursive($val);
			}
			return $rvar;
		}
		elseif( is_string($var) )
		{
			return base64_encode($var);
		}
		else
		{
			return $var;
		}
	}

	/**
	 * @brief base64_decode a variable recursively, array keys and object property names will not be
	 * decoded, so you would better use ASCII to define the array key name or object property name.
	 *
	 * @param [in] mixed $var
	 * @return  mixed, with the same variable type
	 * @retval   
	 * @see 
	 * @note 
	 * @author zhujt
	 * @date 2009/06/03 11:32:33
	**/
	public static function base64_decode_recursive($var)
	{
		if( is_array($var) )
		{
			$rvar = array();
			foreach( $var as $key => $val )
			{
				$rvar[$key] = self::base64_decode_recursive($val);
			}
			return $rvar;
		}
		elseif( is_object($var) )
		{
			$rvar = null;
			foreach( $var as $key => $val )
			{
				$rvar->{$key} = self::base64_decode_recursive($val);
			}
			return $rvar;
		}
		elseif( is_string($var) )
		{
			return base64_decode($var);
		}
		else
		{
			return $var;
		}
	}

	/**
	 * @brief Encode the GBK format var into json format.
	 *
	 * @param [in] mixed $var	The value being encoded. Can be any type except a resource.
	 * @return json format string.
	 * @retval   
	 * @see 
	 * @note The standard json_encode & json_decode needs all strings be in ASCII or UTF-8 format,
	 * but most of the time, we use GBK format strings and the standard ones will not work properly,
	 * by base64_encoded the strings we can change them to ASCII format and let the json_encode &
	 * json_decode functions work.
	 * @author zhujt
	 * @date 2009/06/01 13:56:12
	**/
	public static function json_encode($var)
	{
		return json_encode(self::base64_encode_recursive($var));
	}

	/**
	 * @brief Decode the GBK format var from json format.
	 *
	 * @param [in] string $json	json formated string
	 * @param [in] bool $assoc	When TRUE, returned objects will be converted into associative arrays.
	 * @return mixed, associated array with values be urldecoded
	 * @retval   
	 * @see 
	 * @note The standard json_encode & json_decode needs all strings be in ASCII or UTF-8 format,
	 * but most of the time, we use GBK format strings and the standard ones will not work properly,
	 * by base64_encoded the strings we can change them to ASCII format and let the json_encode &
	 * json_decode functions work.
	 * @author zhujt
	 * @date 2009/06/01 13:56:12
	**/
	public static function json_decode($json, $assoc = false)
	{
		return self::base64_decode_recursive(json_decode($json, $assoc));
	}

	/**
	 * @brief Convert string or array to requested character encoding
	 *
	 * @param mix $val	Array or string to be converted
	 * @param string $in_charset	The input charset.
	 * @param string $out_charset	The output charset
	 * @return mix	The array with all of the values in it noslashed
	 * @retval The array with all of the values in it noslashed
	 * @see http://cn2.php.net/manual/en/function.iconv.php
	 * @note 
	 * @author zhujt
	 * @date 2009/03/16 12:17:09
	**/
	public static function iconv_recursive($val, $in_charset, $out_charset)
	{
		if( $in_charset === $out_charset )
		{
			return $val;
		}

		if( !is_array($val) )
		{
			return iconv($in_charset, $out_charset, $val);
		}
		$ret = array();
		foreach( $val as $key => $value )
		{
			$key = iconv($in_charset, $out_charset, $key);
			$value = self::iconv_recursive($value, $in_charset, $out_charset);
			$ret[$key] = $value;
		}
		return $ret;
	}
}

class BaiduSpaceRestClientException extends BaiduSpaceAPIException
{
	    
}



// Supporting methods and values------


/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */
?>
