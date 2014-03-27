<?php
/***************************************************************************
 * 
 * Copyright (c) 2011 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/

/**
 * @file Session.class.php
 * @author yangyu(yangyu@baidu.com)
 * @brief �û���¼����
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

	public static function check_login()
        {
        $userinfo = array();

		$a_pwd = md5($a_pwd);
		$ip = get_ip();
		//$login_info = $dbs->getRow($sql);	��ȡ�û���Ϣ

        //ret url
        $uss['url'] = sprintf('http://%s%s', $_SERVER['SERVER_NAME'], $_SERVER['REQUEST_URI']);

		//�����½��������
		$time_30 = strtotime($login_info["this_time"])+1800; //30����ǰ
		if (($login_info["times_limit"] >= $times_limit) && ($time_30 > time()))
		{
			echo "<script type='text/javascript'>alert('���Ե�½���������ѵ�,30�����ڴ��ʺŲ����Ե�½��');window.close();</script>";
			exit;
		}
		else
		{
			if ($a_pwd == $login_info["pwd"]) //��½�ɹ�
			{
				session_start();
				$_SESSION["admin_account"] = $login_info["account"];
				$_SESSION["admin_name"] = $login_info["name"];
				$_SESSION["admin_project"] = $login_info["project"];
				$_SESSION["admin_rights"] = $login_info["rights"];
				$_SESSION["admin_user"] = $login_info["admin_user"];
				//��½��¼
				$sql = "UPDATE `admin_accounts` SET `last_time`=`this_time`, `last_ip`=`this_ip`, `this_time`=NOW(), `this_ip`='$ip', `times_limit`=0 WHERE `id`=".$login_info["id"]." LIMIT 1";
				$db->query($sql);
				header("location:".PROJECT_DIR);
				exit;
			}
			else
			{
				//����IP��½���Դ���
				$sql = "UPDATE `admin_accounts` SET `this_time`=NOW(),`this_ip`='$ip',`times_limit`=(`times_limit`+1) WHERE `id`=".$login_info["id"]." LIMIT 1";
				$db->query($sql);
				echo "<script type='text/javascript'>alert('�û������������,�㻹��������".($times_limit-$login_info["times_limit"])."�Σ�');window.history.back();</script>";
			}
		}


        return $uss;
    }    
}
?>
