<?php
/**
 * 获取客户端IP库
 * @example 
 * $strIp = HttpIpRequest::getConnectIp();
 * $strIp = HttpIpRequest::getUserClientIp();
 */
class HttpIpRequest
{
    /**
     * 直接连接WEB服务器的真实IP。如果采用代理，则返回的是代理IP。
     *
     * @var string
     */
    private static $_strConnectIp = null;
    /**
     * 用户客户端的IP。需要完全信任中间代理，所以存在风险。该IP地址可能被用户伪造
     * 具体描述参考http://com.baidu.com/twiki/bin/view/Ns/Get_Ip_Notice
     *
     * @var string
     */
    private static $_strUserClientIp = null;
    /**
     * 获取连接WEB服务器的真实IP。如果采用代理，则返回的是代理IP。
     *
     * @param string默认IP地址 $strDefaultIp
     * @return string
     */
    public static function getConnectIp ($strDefaultIp = '0.0.0.0')
    {
        if (is_null(self::$_strConnectIp)) {
            //获取IP
            $strIp = '';
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $strIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
                //获取最后一个
                $strIp = strip_tags(trim($strIp));
                $intPos = strrpos($strIp, ',');
                if ($intPos > 0) {
                    $strIp = substr($strIp, $intPos + 1);
                }
            } elseif (isset($_SERVER['HTTP_CLIENTIP'])) {
                //transmit 特有的
                $strIp = strip_tags($_SERVER['HTTP_CLIENTIP']);
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $strIp = strip_tags($_SERVER['HTTP_CLIENT_IP']);
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $strIp = strip_tags($_SERVER['REMOTE_ADDR']);
            }
            if (! ip2long($strIp)) {
                //IP地址不合法
                $strIp = $strDefaultIp;
            }
            self::$_strConnectIp = $strIp;
        }
        return self::$_strConnectIp;
    }
    /**
     * 获取用户客户端的IP地址。该IP地址可能被用户伪造
     *
     * @param string默认IP地址 $strDefaultIp
     * @return string
     */
    public static function getUserClientIp ($strDefaultIp = '0.0.0.0')
    {
        if (is_null(self::$_strUserClientIp)) {
            $strIp = '';
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $strIp = strip_tags($_SERVER['HTTP_X_FORWARDED_FOR']);
                //获取第一个
                $intPos = strpos($strIp, ',');
                if ($intPos > 0) {
                    $strIp = substr($strIp, 0, $intPos);
                }
            } elseif (isset($_SERVER['HTTP_CLIENTIP'])) {
                //transmit特有
                $strIp = strip_tags($_SERVER['HTTP_CLIENTIP']);
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $strIp = strip_tags($_SERVER['HTTP_CLIENT_IP']);
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $strIp = strip_tags($_SERVER['REMOTE_ADDR']);
            }
            if (! ip2long($strIp)) {
                $strIp = $strDefaultIp;
            }
            self::$_strUserClientIp = $strIp;
        }
        return self::$_strUserClientIp;
    }
}
