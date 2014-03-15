<?php
/**
 * IDC config
 *
 * @package bingo/config
 * @author  zhangdongjin@baidu.com
 */

class IDCConfig
{
    // IDC count
    const COUNT = 3;

    // all your IDCs
    const IDC_TC = 'tc';
    const IDC_JX = 'jx';
	const IDC_HZ = 'hz';

    // current IDC
    const CURRENT = IDCConfig::IDC_TC;
}

class ZcacheConf
{
                static $arrconfig = array(
                //持续连接
                'PERSISTENT' => 0,
                //连接超时，秒级
                'CONNTIMEOUT' => 2,
                //MCPACK版本
                'MCPACK_VERSION' => PHP_MC_PACK_V1,
                //product name
                'arrPName' => array(0 =>"video_ex"),
                //token
                'arrToken' => array(0 =>"video_ex"),
                //retry time
                'RETRYTIME' => 3,  
                'CURRENT_CONF' => IDCConfig::CURRENT,
                'arrServers'=> array(
                        IDCConfig::IDC_JX => array(  
                                    "socket_address" => "10.36.7.89",
                                        "socket_port" => 10240,
                                        "socket_timeout" => 500 
                                        ),  
                        IDCConfig::IDC_TC => array(
                                  "socket_address" => "127.0.0.1",
                                        "socket_port" => 10240,
                                        "socket_timeout" => 1000
                                )
                        )
                );
}

class IMSGConfig
{
        static $arrServers = array(
            IDCConfig::IDC_JX => "http://10.65.211.25:8001/mmsg/r",
            IDCConfig::IDC_TC => "http://10.26.7.131:8001/mmsg/r",
            );      
} 

class IpadCommendConf
{
   static $arrServers = array(
       IDCConfig::IDC_JX => array(
           "socket_address" => "127.0.0.1",
           "socket_port" => 8892,
           ),
       IDCConfig::IDC_TC => array(
           "socket_address" => "127.0.0.1",
           "socket_port" => 8892,
         )
     );
}

class ApacheConf
{
    // 完备配置
    static $_HOSTS_ALL = array(
        // TC机房
        IDCConfig::IDC_TC => array(
            "10.23.244.244:8080",
            "10.23.241.234:8080",
            "10.23.238.112:8080",
            "10.23.244.134:8080",
            "10.23.245.28:8080",
            "10.23.250.28:8080",
            "10.26.151.43:8080",
        ),
        //JX机房
        IDCConfig::IDC_JX => array(
            "10.65.24.118:8080",
            "10.65.9.73:8080",
            "10.65.10.163:8080",
            "10.65.39.156:8080",
            "10.65.39.155:8080",
            "10.65.33.173:8080",
            "10.65.33.175:8080",
            "10.65.33.137:8080",
            "10.65.32.39:8080",
            "10.65.32.40:8080",
        )
    );
    // 当前机房的配置
    static $HOSTS;
}
// 当前机房的配置
ApacheConf::$HOSTS = ApacheConf::$_HOSTS_ALL[IDCConfig::CURRENT];

class MemcachedConf
{
    static $PORT = 11211;
    // 完备配置
    static $_HOSTS_ALL = array(
        // TC机房
        IDCConfig::IDC_TC => array(
            "10.23.255.62",
            "10.23.244.172",
        ),
        //JX机房
        IDCConfig::IDC_JX => array(
            "10.65.12.187",
            "10.65.16.131",
        )
    );
    // 当前机房的配置
    static $HOSTS;
}
MemcachedConf::$HOSTS = MemcachedConf::$_HOSTS_ALL[IDCConfig::CURRENT];


//Redis配置
class RedisConf
{
    static $_HOSTS_ALL = array(
        // TC机房
        IDCConfig::IDC_TC => array(
			'master' => array(
				array(
					'host' => '10.46.225.15',
					'port' => '9980',
				),
			),
			'slave' => array(
				array(
					'host' => '10.42.94.43',
					'port' => '9980',
				),
				array(
					'host' => '10.42.95.22',
					'port' => '9980',
				),
			),
        ),
        //JX机房
        IDCConfig::IDC_JX => array(
			'master' => array(
				array(
					'host' => '10.46.225.15',
					'port' => '9980',
				),
			),
			'slave' => array(
				array(
					'host' => '10.42.94.43',
					'port' => '9980',
				),
				array(
					'host' => '10.42.95.22',
					'port' => '9980',
				),
			),
        ),
		//HZ机房
        IDCConfig::IDC_HZ => array(
			'master' => array(
				array(
					'host' => '10.46.225.15',
					'port' => '9980',
				),
			),
			'slave' => array(
				array(
					'host' => '10.212.54.15',
					'port' => '9980',
				),
				array(
					'host' => '10.212.37.34',
					'port' => '9980',
				),
			),
        ),
    );
    // 当前机房的配置
    static $HOSTS;
}
RedisConf::$HOSTS = RedisConf::$_HOSTS_ALL[IDCConfig::CURRENT];



//session 服务器
class LibPassportConfig
{
 const PPSESS_APPID = 0x0427;
 //const PPUSER_APPID = 6;
 //const P_USERINFO_VERSION = '1.0';
 //const P_USERINFO_ID = 13;

 //交互失败重试次数
 const RETRY_TIMES = 2;
 //连接超时时间，单位ms，利用curl时不能小于1000
 const CONNECT_TIMEOUT = 1000;
 //交互超时时间，单位ms
 const TIMEOUT = 1000;

 //session服务器配置数组
 static $arrSessionServer = array(
  IDCConfig::IDC_JX => array(
    'http://10.26.7.72:7801/',
	//'http://10.23.247.131:7801/',
  ),
  IDCConfig::IDC_TC => array(
    'http://10.36.7.65:7801/',
	//'http://10.23.247.131:7801/',
  )
 );

 /*
 //uinfo服务器配置数组
 static $arrUinfoServer = array(
  IDCConfig::IDC_JX => array(
    'http://tc-jp-test00.tc.baidu.com:1080/service/passport',
    'http://tc-jp-test00.tc.baidu.com:1080/service/passport'
  ),
  IDCConfig::IDC_TC => array(
    'http://tc-jp-test00.tc.baidu.com:1080/service/passport',
    'http://tc-jp-test00.tc.baidu.com:1080/service/passport'
  )
 );
  */
}

/* example
    
class RSConf
{
    const PORT = 4000;
    // 完备配置
    static $_HOSTS_ALL = array(
        // TC机房
        IDCConfig::IDC_TC => array(
            "1.1.1.1",
            "2.2.2.2",
        ),
        //JX机房
        IDCConfig::IDC_JX => array(
            "3.3.3.3",
            "4.4.4.4",
        )
    );
    // 当前机房的配置
    static $HOSTS;
}
// 当前机房的配置
RSConf::$HOSTS = RSConf::$_HOSTS_ALL [IDCConfig::CURRENT];

print_r(RSConf::$HOSTS);
*/
//数据库配置
class DatabaseConf
{
  // 完备配置
  static $_UGC_ALL = array(
    // TC机房
    IDCConfig::IDC_TC => array(
			#默认配置
			array(
			  'host' => '10.81.52.7',
			  'username'=>'vs_video_ugc_w',
			  'password'=>'smpN3raL2kz',
			  'port'=>'4001'
			), 
			#备用配置
			array(
			  'host' => '10.81.52.9',
			  'username'=>'vs_video_ugc_w',
			  'password'=>'smpN3raL2kz',
			  'port'=>'4001'
		  ) 
    ),
    //JX机房
    IDCConfig::IDC_JX => array(
			#默认配置
			array(
			  'host' => '10.36.125.5',
			  'username'=>'vs_video_ugc_w',
			  'password'=>'smpN3raL2kz',
			  'port'=>'4001'
			), 
			#备用配置
			array(
			  'host' => '10.36.125.6',
			  'username'=>'vs_video_ugc_w',
			  'password'=>'smpN3raL2kz',
			  'port'=>'4001'
		  ) 
    )
  );
  // 当前机房的配置
  static $UGC;
}
DatabaseConf::$UGC = DatabaseConf::$_UGC_ALL[IDCConfig::CURRENT];

?>
