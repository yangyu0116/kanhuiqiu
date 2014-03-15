<?php
/***************************************************************************
 * 
 * Copyright (c) 2011 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/

/**
 * @file Session.class.php
 * @author wujian01(wujian01@baidu.com)
 * @date 2011-11-30 
 * @brief 用户登录服务
 **/
class Session
{
	public static function api_encode_uid($uid) {
		$sid = ($uid & 0x0000ff00) << 16;
		$sid += (($uid & 0xff000000) >> 8) & 0x00ff0000;
		$sid += ($uid & 0x000000ff) << 8;
		$sid += ($uid & 0x00ff0000) >> 16;
		$sid ^= 282335;
		return $sid;
	}

	public static function checkUserLogin()
        {
        $uss = array();
		$pass_res = Passport::checkUserLogin();

        //ret url
        $uss['url'] = sprintf('http://%s%s', $_SERVER['SERVER_NAME'], $_SERVER['REQUEST_URI']);

        //host
        $uss['host'] = GlobalConfig::$passport_host;
        if ($pass_res === false) {
            $uss['islogin'] = false;
            $uss['uname'] = '';
            $uss['uid']   = '';
            $uss['email'] = '';
            $uss['phone'] = '';
            $uss['isspace'] = false;
            $uss['global_data'][0] = 0;
        }
        else{
			//$pass_res['uid'] = 608709854;
            $uss['islogin'] = true;
            $uss['uname'] = $pass_res['un'];
            $uss['uid']   = self::api_encode_uid($pass_res['uid']);
            $uss['email'] = $pass_res['email'];
            $uss['phone'] = $pass_res['phone'];
            $uss['global_data'] = $pass_res['global_data'];
			if ((ord($uss['global_data'][0]) & 0x20) != 0){
                $uss['isspace'] = true;
            }
            else{
                $uss['isspace'] = false;
            }
        }

		//测试信息
		$uss = array('islogin' => 1, 'uid' => '1077795095', 'uname' => '幸存者201311');

        return $uss;
    }    
}
?>
