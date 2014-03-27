<?php
/**
 * ��ȡ�ͻ���IP��
 * @example 
 * $strIp = HttpIpRequest::getConnectIp();
 * $strIp = HttpIpRequest::getUserClientIp();
 */
class HttpIpRequest
{
    /**
     * ֱ������WEB����������ʵIP��������ô����򷵻ص��Ǵ���IP��
     *
     * @var string
     */
    private static $_strConnectIp = null;
    /**
     * �û��ͻ��˵�IP����Ҫ��ȫ�����м�������Դ��ڷ��ա���IP��ַ���ܱ��û�α��
     * ���������ο�http://com.baidu.com/twiki/bin/view/Ns/Get_Ip_Notice
     *
     * @var string
     */
    private static $_strUserClientIp = null;
    /**
     * ��ȡ����WEB����������ʵIP��������ô����򷵻ص��Ǵ���IP��
     *
     * @param stringĬ��IP��ַ $strDefaultIp
     * @return string
     */
    public static function getConnectIp ($strDefaultIp = '0.0.0.0')
    {
        if (is_null(self::$_strConnectIp)) {
            //��ȡIP
            $strIp = '';
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $strIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
                //��ȡ���һ��
                $strIp = strip_tags(trim($strIp));
                $intPos = strrpos($strIp, ',');
                if ($intPos > 0) {
                    $strIp = substr($strIp, $intPos + 1);
                }
            } elseif (isset($_SERVER['HTTP_CLIENTIP'])) {
                //transmit ���е�
                $strIp = strip_tags($_SERVER['HTTP_CLIENTIP']);
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $strIp = strip_tags($_SERVER['HTTP_CLIENT_IP']);
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $strIp = strip_tags($_SERVER['REMOTE_ADDR']);
            }
            if (! ip2long($strIp)) {
                //IP��ַ���Ϸ�
                $strIp = $strDefaultIp;
            }
            self::$_strConnectIp = $strIp;
        }
        return self::$_strConnectIp;
    }
    /**
     * ��ȡ�û��ͻ��˵�IP��ַ����IP��ַ���ܱ��û�α��
     *
     * @param stringĬ��IP��ַ $strDefaultIp
     * @return string
     */
    public static function getUserClientIp ($strDefaultIp = '0.0.0.0')
    {
        if (is_null(self::$_strUserClientIp)) {
            $strIp = '';
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $strIp = strip_tags($_SERVER['HTTP_X_FORWARDED_FOR']);
                //��ȡ��һ��
                $intPos = strpos($strIp, ',');
                if ($intPos > 0) {
                    $strIp = substr($strIp, 0, $intPos);
                }
            } elseif (isset($_SERVER['HTTP_CLIENTIP'])) {
                //transmit����
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
