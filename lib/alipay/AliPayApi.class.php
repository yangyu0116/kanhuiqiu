<?php

/**
 * 类名: AliPayApi
 * 功能: 支付宝支付流程使用的接口
 *
 */
//require_once 'conf/config.php';
//require_once 'conf/trade_conf.php';
//require_once 'include/log.php';

class AliPayApi
{
    /**
     * RSA签名
     * $data待签名数据
     * 签名用商户私钥，必须是没有经过pkcs8转换的私钥
     * 最后的签名，需要用base64编码
     * return Sign签名
     */
    static function sign ($data)
    {
        // 读取私钥文件
        $priKey = file_get_contents(PayConfig::$privatekeyfile);

        // 转换为openssl密钥，必须是没有经过pkcs8转换的私钥
        $res = openssl_get_privatekey($priKey);

        // 调用openssl内置签名方法，生成签名$sign
        openssl_sign($data, $sign, $res);

        // 释放资源
        openssl_free_key($res);

        // base64编码
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * RSA验签
     * $data待签名数据
     * $sign需要验签的签名
     * 验签用支付宝公钥
     * return 验签是否通过 bool值
     */
    static function verify ($array, $sign)
    {
		$data = self::getSignVeryfy($array);

        // 读取支付宝公钥文件
        $pubKey = file_get_contents(PayConfig::$publickeyfile);

		// 转换为openssl格式密钥
        $res = openssl_get_publickey($pubKey);
        // 调用openssl内置方法验签，返回bool值
        $result = (bool) openssl_verify($data, base64_decode($sign), $res);
        //$result = (bool) openssl_verify($data, $sign, $res);

        // 释放资源
        openssl_free_key($res);

        // 返回资源是否成功
        return $result;
    }


	/**
	 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	static function createLinkstring($para) {
		$arg  = "";
		while (list ($key, $val) = each ($para)) {
			$arg.=$key."=".$val."&";
		}
		//去掉最后一个&字符
		$arg = substr($arg,0,count($arg)-2);
		
		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
		
		return $arg;
	}

	/**
	 * 远程获取数据，GET模式
	 * 注意：
	 * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
	 * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
	 * @param $url 指定URL完整路径地址
	 * @param $cacert_url 指定当前工作目录绝对路径
	 * return 远程输出的数据
	 */
	static function getHttpResponseGET($url) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL证书认证
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
		curl_setopt($curl, CURLOPT_CAINFO, PayConfig::$cacertfile);//证书地址
		$responseText = curl_exec($curl);
		//var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
		curl_close($curl);
		
		return $responseText;
	}


	    /**
     * 获取返回时的签名验证结果
     * @param $para_temp 通知返回来的参数数组
     * @param $sign 返回的签名结果
     * @return 签名验证结果
     */
	static function getSignVeryfy($para_temp) {
		//除去待签名参数数组中的空值和签名参数
		$para_filter = self::paraFilter($para_temp);
		
		//对待签名参数数组排序
		$para_sort = self::argSort($para_filter);
		
		//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$prestr = self::createLinkstring($para_sort);
		
		return $prestr;
	}

	/**
	 * 除去数组中的空值和签名参数
	 * @param $para 签名参数组
	 * return 去掉空值与签名参数后的新签名参数组
	 */
	static function paraFilter($para) {
		$para_filter = array();
		while (list ($key, $val) = each ($para)) {
			if($key == "sign" || $key == "sign_type" || $val == "")continue;
			else	$para_filter[$key] = $para[$key];
		}
		return $para_filter;
	}

	/**
		 * 对数组排序
		 * @param $para 排序前的数组
		 * return 排序后的数组
		 */
	static function argSort($para) {
			ksort($para);
			reset($para);
			return $para;
	}

	/**
	 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	static function createLinkstringUrlencode($para) {
		$arg  = "";
		while (list ($key, $val) = each ($para)) {
			$arg.=$key."=".urlencode($val)."&";
		}
		//去掉最后一个&字符
		$arg = substr($arg,0,count($arg)-2);
		
		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
		
		return $arg;
	}

}
?>
