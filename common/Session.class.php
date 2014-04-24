<?php
class Session
{
	public static $cookie_pre = 'khq_cookie_';
	public static $login_cookie_pre = 'khq_user_';

	public static function check_login(){

        $userinfo = array();

		//$login_user_info = self::get_cookie_var('login_user');
		$cookie_user_info = self::get_cookie_var('user');

		//substr($uid, 0, 32);

		$uid = $uname = '';
		if (!empty($cookie_user_info)){
			//$tmp_user_info = explode("\t", self::str_code($cookie_user_info,'DECODE'));
			//$uid = $tmp_user_info[0];
			$uname = isset($tmp_user_info[1]) ? $tmp_user_info : '';
			//$decode_cookie_user_info = self::_decrypt($cookie_user_info);

			$uid = self::_decrypt($cookie_user_info);
		}

		if (empty($uid)){

			$uid = GlobalConfig::$timestamp.rand(0,1000);

			$storage = new Storage('kanhuiqiu');
			$m_user = new UserModel(UserConfig::$cache_config, $storage->db, null);
			$m_user->add_cookie_user($uid);

			//$cookie_val = self::str_code($uid,'ENCODE');
			$cookie_val = self::_encrypt($uid);
			self::set_cookie('user', $cookie_val);
		}

		$userinfo['uid'] = $uid;
		$userinfo['uname'] = $uname;

        return $userinfo;
    }  

	public static function get_cookie_var($var){
		return isset($_COOKIE[self::$cookie_pre.$var]) ? $_COOKIE[self::$cookie_pre.$var] : '';
	}

	public static function set_cookie($ck_var, $ck_value, $ck_time='F', $httponly = true){

		$timestamp = GlobalConfig::$timestamp;
		$db_ckpath = '/';
		if ($_SERVER['HTTP_HOST'] == 'k') {
			$db_ckpath = '/';
			$db_ckdomain = '';
		} else {
			if (!isset($db_ckdomain)) {
				$pre_host = strtolower(substr($_SERVER['HTTP_HOST'],0,strpos($_SERVER['HTTP_HOST'],'.'))+1);
				$db_ckdomain = substr($_SERVER['HTTP_HOST'],strpos($_SERVER['HTTP_HOST'],'.')+1);
				$db_ckdomain = '.'.((strpos($db_ckdomain,'.')===false) ? $_SERVER['HTTP_HOST'] : $db_ckdomain);
				//if (strpos($B_url,$pre_host)!==false) {
					$db_ckdomain = $pre_host.$db_ckdomain;
				//}
			}
		}
		if ($ck_time=='F') {
			$ck_time = $timestamp+31536000;	//1 year
		} else {
			($ck_value=='' && $ck_time==0) && $ck_time = $timestamp-31536000;
		}


		$cookie_exec = setcookie(self::$cookie_pre.$ck_var, $ck_value, $ck_time, $db_ckpath, $db_ckdomain, self::get_secure(), $httponly);
		
		if ($cookie_exec){
			$_COOKIE[self::$cookie_pre.$ck_var] = $ck_value;
		}
		
		return true;
	}

	public static function get_secure(){
		return false;
		/*
		$https = array();
		$_SERVER['REQUEST_URI'] && $https = @parse_url($_SERVER['REQUEST_URI']);
		if (empty($https['scheme'])) {
			if (isset($_SERVER['HTTP_SCHEME'])) {
				$https['scheme'] = $_SERVER['HTTP_SCHEME'];
			} else {
				$https['scheme'] = ($_SERVER['HTTPS'] && strtolower($_SERVER['HTTPS']) != 'off') ? 'https' : 'http';
			}
		}
		if ($https['scheme'] == 'https'){
			return true;
		}
		return false;
		*/
	}

	
	/*
	public static function login(){

        $userinfo = array();

		//$login_info = $dbs->getRow($sql);	获取用户信息

        //ret url
        $uss['url'] = sprintf('http://%s%s', $_SERVER['SERVER_NAME'], $_SERVER['REQUEST_URI']);

		//错误登陆次数限制
		$time_30 = strtotime($login_info["this_time"])+1800; //30分钟前
		if (($login_info["times_limit"] >= $times_limit) && ($time_30 > time()))
		{
			echo "<script type='text/javascript'>alert('重试登陆次数限制已到,30分钟内此帐号不可以登陆！');window.close();</script>";
			exit;
		}
		else
		{
			if ($a_pwd == $login_info["pwd"]) //登陆成功
			{
				session_start();
				$_SESSION["admin_account"] = $login_info["account"];
				$_SESSION["admin_name"] = $login_info["name"];
				//登陆记录
				$sql = "UPDATE `admin_accounts` SET `last_time`=`this_time`, `last_ip`=`this_ip`, `this_time`=NOW(), `this_ip`='$ip', `times_limit`=0 WHERE `id`=".$login_info["id"]." LIMIT 1";
				$db->query($sql);
				header("location:".PROJECT_DIR);
				exit;
			}
			else
			{
				//限制IP登陆重试次数
				$sql = "UPDATE `admin_accounts` SET `this_time`=NOW(),`this_ip`='$ip',`times_limit`=(`times_limit`+1) WHERE `id`=".$login_info["id"]." LIMIT 1";
				$db->query($sql);
				echo "<script type='text/javascript'>alert('用户名或密码错误,你还可以重试".($times_limit-$login_info["times_limit"])."次！');window.history.back();</script>";
			}
		}


        return $uss;
    }


	public static function get_user_info(){
		global $db,$timestamp,$db_onlinetime,$winduid,$windpwd,$db_ifonlinetime,$c_oltime,$onlineip,$db_ipcheck;
		$rt = $db->get_one("SELECT u.*,ui.* FROM pw_user u LEFT JOIN pw_userinfo ui USING(uid) WHERE u.uid='$winduid'");
		$loginout = 0;
		if ($db_ipcheck==1 && strpos($rt['onlineip'],$onlineip)===false) {
			$iparray  = explode('.',$onlineip);
			strpos($rt['onlineip'],$iparray[0].'.'.$iparray[1])===false && $loginout = 1;
			unset($iparray);
		}
		if (!$rt || PwdCode($rt['password']) != $windpwd || $loginout==1) {
			unset($rt); $GLOBALS['groupid']='2';
			if (!function_exists('Loginout')) {
				require_once(R_P.'mod/checkpass_mod.php');
			}
			Loginout();
			Showmsg('ip_change');
		} else {
			$rt['uid'] = $winduid;
			$rt['password'] = null;
			if ($timestamp-$rt['lastvisit']>$db_onlinetime || $timestamp-$rt['lastvisit']>3600) {
				$ct = "lastvisit='$timestamp',thisvisit='$timestamp'";
				if ($db_ifonlinetime==1 && $c_oltime > 0) {
					($c_oltime>$db_onlinetime*1.2) && $c_oltime = $db_onlinetime;
					$ct .= ",onlinetime=onlinetime+'$c_oltime'";
					$c_oltime=0;
				}
				$db->update("UPDATE pw_user SET $ct WHERE uid='$winduid'");
			}
		}
		return $rt;
	}
	*/


	public static function str_code($string, $action='ENCODE'){
		$key	= substr(md5($_SERVER["HTTP_USER_AGENT"].GlobalConfig::$strhash),8,18);
		$action == 'DECODE' && $string = base64_decode($string);
		$len	= strlen($key); $code = '';
		for ($i=0; $i<strlen($string); $i++) {
			$k		= $i % $len;
			$code  .= $string[$i] ^ $key[$k];
		}
		$action == 'ENCODE' && $code = base64_encode($code);
		return $code;
	}

	public static function _encrypt($plainText){

        $key = GlobalConfig::$strhash;
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $encryptText = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $plainText, MCRYPT_MODE_ECB, $iv);
        return trim(base64_encode($encryptText));

    }

	public static function _decrypt($encryptedText){

        $key = GlobalConfig::$strhash;
        $cryptText = base64_decode($encryptedText);
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $decryptText = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $cryptText, MCRYPT_MODE_ECB, $iv);
        return trim($decryptText);
    }
}
