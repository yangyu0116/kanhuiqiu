<?php

class Passport
{
	
    const BAIDU_COOKIE = 'BDUSS';
    const SESSION_ID_MIN_LEN = 32;
	const SSN_GET_SESSION_DATA_BY_SID = 0x00102;
    const SSN_RSTATUS_OK = 0x000;
    
    private static $error = '';

	/**
     * @brief ����uid��ȡ�û���Ϣ
     *
	 * @param [in] int $intUserID
	 * @param [in] array $arrField	ָ����ȡ���ֶ�
     * @return �û������ڻ򽻻�ʧ�ܷ���false�����򷵻ع�������
	 * @retval
     * @see 
     * @note 
     * @author yujianjia 
     * @date 2009/07/06 14:20:35
    **/
	public static function getInfoByuid($intUserID, $arrField = false)
	{
		return self::getInfoFromPassport('uid', $intUserID, $arrField);
	}

	/**
     * @brief ����un��ȡ�û���Ϣ
     *
	 * @param [in] int $strUserName	�û���
	 * @param [in] array $arrField	ָ����ȡ���ֶ�
     * @return �û������ڻ򽻻�ʧ�ܷ���false�����򷵻ع�������
	 * @retval
     * @see 
     * @note 
     * @author yujianjia 
     * @date 2009/07/06 14:20:35
    **/
	public static function getInfoByun($strUserName, $arrField = false)
	{
		return self::getInfoFromPassport('un', $strUserName, $arrField);
	}

	/**
     * @brief ��֤�û����������Ƿ���ȷ
     *
	 * @param [in] string $strUserName	�û���
	 * @param [in] string $strPasswd	����
	 * @param [in] bool $bolMark
	 * @param [in] bool $bolMd5
     * @return �û��������벻��ȷ����֤���̳���ʧ�ܷ���false�����򷵻�
	 *	array('status' => 1, 'uid' => int, 'un' => string, ...)
	 * @retval
     * @see 
     * @note 
     * @author yujianjia 
     * @date 2009/07/06 14:20:35
    **/
	public static function loginVerify($strUserName, $strPasswd, $bolMark = false, $bolMd5 = false)
	{
		$arrUinfoServer = LibPassportConfig::$arrUinfoServer[IDCConfig::CURRENT];

		for( $i = 0; $i < LibPassportConfig::RETRY_TIMES; ++$i )	//֧����������
		{
			if( count($arrUinfoServer) <= 0 ) break;
			//���ѡ��һ��session������
			$intIndex = array_rand($arrUinfoServer);
			$strServer =  $arrUinfoServer[$intIndex];

			$strUrl = sprintf('%s?v=%s&aid=%d&a=verify&un=%s&pw=%s&ip=%s&mark=%d&md5=%d',
					$strServer, LibPassportConfig::P_USERINFO_VERSION, LibPassportConfig::P_USERINFO_ID,
					$strUserName, $strPasswd, '127.0.0.1', intval($bolMark), intval($bolMd5));
			$strHttpRet = self::doGetRequest($strUrl);
			if( $strHttpRet === false )
			{
				unset($arrUinfoServer[$intIndex]);
				continue;
			}
			parse_str($strHttpRet, $arrResp);
			if( !is_array($arrResp) || !isset($arrResp['status']) )
			{
				self::$error = 'response with no status';
				return false;
			}
			elseif( $arrResp['status'] == 0 )
			{
				self::$error = $arrResp['message'];
				return false;
			}

			return $arrResp;
		}
		return false;
	}
    
    /**
     * @brief ���$bduss��Ӧ��session id�ĵ�¼���
     *
	 * @param [in] string $strBduss	BDUSS cookie�Ϊ��ʱֱ����$_COOKIE['BDUSS']��Ϊbdussֵ
     * @return δ��¼�򽻻�ʧ�ܷ���false��
     *         ���򷵻ص�¼�û���Ӧ�� array('uid' => int, 'un' => string, 
	 *	  								'global_data'=> string, 'private_data'=>string)
	 * @retval
     * @see 
     * @note 
     * @author yujianjia 
     * @date 2009/07/06 14:20:35
    **/
    public static function checkUserLogin($strBduss = null)
	{

		$strBduss = "kdmTH5reXdXVG1mb1F5aGJDa3UzN3dXM2JTTk04TkEtczZWNmRaVzloc2p5LTlSQVFBQUFBJCQAAAAAAAAAAAEAAAAsqjQGsNfR8sbww~sAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACM-yFEjPshRU";

		//$strBduss = 'WxMZmpTQUN1QWNscXBNcFR2WVpzeTk1N2dRNjRqUEczSy1jSXRkN2l-cFZDeXhTQVFBQUFBJCQAAAAAAAAAAAEAAAAssSc1cGNwY3BjMTIzNDQ0AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFV-BFJVfgRSS';
		
    	if( empty($strBduss) )
		{
    		if( !empty($_COOKIE[self::BAIDU_COOKIE]) )
			{
    			$strBduss = $_COOKIE[self::BAIDU_COOKIE];
    		}
			else
			{
    			self::$error = 'BDUSS not exist';
    			return false;
    		}
    	}
    	if( strlen($strBduss) < self::SESSION_ID_MIN_LEN )
		{
    		self::$error = 'strlen(BDUSS) is ' . strlen($strBduss) . ' which is less than ' . self::SESSION_ID_MIN_LEN;
			return false;
    	}

		$arrSessionServer = LibPassportConfig::$arrSessionServer[IDCConfig::CURRENT];

		for( $i = 0; $i < LibPassportConfig::RETRY_TIMES; ++$i )	//֧����������
		{
			if( count($arrSessionServer) <= 0 ) break;
			//���ѡ��һ��session������
			$intIndex = array_rand($arrSessionServer);
			$strServer =  $arrSessionServer[$intIndex];

    		$arrUserInfo = self::handleCheckUserLogin($strServer, $strBduss, LibPassportConfig::PPSESS_APPID, $bolFlag);
			if( $bolFlag )
			{
				return $arrUserInfo;
			}
			unset($arrSessionServer[$intIndex]);
    	}
		return false;
	}

	/**
	 * @brief �������һ����passport���񽻻����ֵĴ�����Ϣ
	 *
	 * @return string 
	 * @retval   
	 * @see 
	 * @note 
	 * @author yujianjia 
	 * @date 2009/07/06 14:57:57
	**/
	public static function error()
	{
		return self::$error;
	}

    private static function handleCheckUserLogin($strUrl, $strBduss, $intAppId, &$bolFlag)
	{
		$bolFlag = true;
		$strUrl = sprintf('%sssn?apid=%d&cm=%d&sid=%s&cip=%s&incomplete_user=1', $strUrl, $intAppId,
            self::SSN_GET_SESSION_DATA_BY_SID, $strBduss, $_SERVER['SERVER_ADDR']);
		$strResult = self::doGetRequest($strUrl);
		if( false === $strResult )
		{
			$bolFlag = false;
			return false;
		}   
        parse_str($strResult, $arrResp);
        if( !isset($arrResp['status']) )
		{
        	self::$error = 'session response status not exist';
        	return false;
        }
        if( $arrResp['status'] != self::SSN_RSTATUS_OK )
		{
        	self::$error = 'session response status is not valid:'.$arrResp['status'];
			return false;
        }
        else if(intval($arrResp['uid']) == 0)
        {
            return false;
        }
        else
		{
			return array('uid' => intval($arrResp['uid']),
						 'un' => $arrResp['username'],
                         'email' => $arrResp['secureemail'],
                         'phone' => $arrResp['securemobil'],
						 'global_data' => $arrResp['global_data'],
                         'private_data' => $arrResp['private_data'],
						 );
        }
	}
    
	private static function getInfoFromPassport($strCheckField, $mixedCheckValue, $arrField = false)
	{
		$arrUinfoServer = LibPassportConfig::$arrUinfoServer[IDCConfig::CURRENT];

		for( $i = 0; $i < LibPassportConfig::RETRY_TIMES; ++$i )	//֧����������
		{
			if( count($arrUinfoServer) <= 0 ) break;
			//���ѡ��һ��session������
			$intIndex = array_rand($arrUinfoServer);
			$strServer =  $arrUinfoServer[$intIndex];

    		$strUrl = sprintf('%s?v=%s&aid=%d&a=query&%s=%s', $strServer, LibPassportConfig::P_USERINFO_VERSION,
						LibPassportConfig::P_USERINFO_ID, $strCheckField, urlencode($mixedCheckValue));
			if( !empty($arrField) )
			{
	    		$strField = '';
	    		foreach( $arrField as $strVal )
				{
					$strField .= $strVal .',';
	    		}
	    		$strUrl .= '&field=' . $strField;
			}
			$strHttpRet = self::doGetRequest($strUrl);
			if( $strHttpRet === false )
			{
				unset($arrUinfoServer[$intIndex]);
				continue;
			}
			parse_str($strHttpRet, $arrResp);
			$bolFlag = self::handlePUserInfoRet($arrResp);
			if( $bolFlag === false )
			{
				return false;
			}
			return $arrResp;
    	}
    	return false;
	}

    private static function handlePUserInfoRet(&$arrResp)
	{
		if( intval($arrResp['status']) !== 1 )
		{
			self::$error = ' response status is ' . $arrResp['status'];
			return false;
		}
		if( intval($arrResp['total']) !== 1 )
		{
			self::$error = 'specified user is not exist';
			return false;
		}
		if( isset($arrResp['userinfo']) )
		{
			unset($arrResp['userinfo']);
		}
		unset($arrResp['status']);
		unset($arrResp['total']);
		
		if( !empty($arrResp['taginfo']) )
		{
			$arrTmpInfo = array();
			$arrPerInfo = explode('%01', rawurlencode($arrResp['taginfo']));
			$strSep = ',';
			for( $j = 0; $j < 10; ++$j )
			{   
				if( $j < 2 )
				{   
					$strSep = '-';
				}
				else
				{   
					$strSep = ',';
				}   
				$strTmp = str_replace('%02', $strSep, substr($arrPerInfo[$j], 3));
				$arrTmpInfo[] = rawurldecode($strTmp);
			}   	
			$arrResp['taginfo'] = $arrTmpInfo;
		}
		return true;
	}

    private static function doGetRequest($strUrl)
	{
        $ch = curl_init();

        $curl_opts = array(
            CURLOPT_URL => $strUrl,
            CURLOPT_CONNECTTIMEOUT => intval(LibPassportConfig::CONNECT_TIMEOUT/1000),
            CURLOPT_TIMEOUT => intval(LibPassportConfig::TIMEOUT/1000),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
        );

        curl_setopt_array($ch, $curl_opts);

        $response = curl_exec($ch);
        $errno = curl_errno($ch);
        self::$error = curl_error($ch);

        curl_close($ch);
        return $response;
    }
}

?>
