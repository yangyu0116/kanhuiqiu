<?php
/***************************************************************************
 * 
 * Copyright (c) 2011 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
 
require_once(dirname(__FILE__)."/aclient.php");
require_once(dirname(__FILE__)."/source/galileo.class.php");
 
 
/**
 * @file mcclient.class.php
 * @author wangweibing(com@baidu.com)
 * @date 2011/05/13 14:47:43
 * @brief 
 *  
 **/

class McClient {
    private $conf = null;
    private $mc_list = null;          /**< memcached机房列表, 0为本机房       */
    private $idc_type = null;


    public function __construct($conf) {
        $pid = $conf['pid'];
        $zk_path = $conf['zk_path'];
        $zk_host = implode(',', @AClient::$global_conf['ZookeeperHost']);
        $zk_expire = $conf['zk_expire'];
        $zk_conf_key = "McClient_conf_$pid";
        $zk_bak_key = $zk_conf_key . "_bak";
        $zk_conf_path = "$zk_path/product/$pid";

        $zk = new zookeeper($zk_host);
        $zk_conf = AClientUtils::zk_get($zk, $zk_conf_path, 5, 2);

        if (!is_array($zk_conf)) {
            return;
        }
        $idc_num = $zk_conf['idc_num'];
        $idc_type = $zk_conf['idc_type'];
        $curr_idc = $zk_conf['curr_idc'] - 1;
        if ($idc_type == "none") {
            $idc_num = 1;
            $curr_idc = 0;
        }

        $mc_list = array();
        for($i = 0; $i < $idc_num; $i++) {
            $idc = ($i + $curr_idc) % $idc_num + 1;
            $server_list = @$zk_conf['children']['server_list' . $idc]['children'];
            var_dump($server_list);
            if (!is_array($server_list)) {
                $this->_warning("server list[$idc] error");
            }

            $mc = new Memcached;
            foreach ($server_list as $server) {
                if (!isset($server['port'])) {
                    $server['port'] = $server['Port'];
                }
                $mc->addServer($server['ip'], $server['port'], $server['weight']);
            }
            $mc_list[] = $mc;
        }

        $this->conf = $conf;
        $this->mc_list = $mc_list;
        $this->idc_type = $idc_type;
    }

    function _add($mc, $key, $value, $expire) {
        $ret = $mc->add($key, $value, $expire);
        if ($ret == false && $mc->getResultCode() != Memcached::RES_NOTSTORED) {
            $this->_warning("add key[$key] error", $mc);
        }
        return $ret;
    }

    public function add($key, $value, $expire = null) {
        if (is_null($expire)) {
            $expire = @$this->conf['default_expire'];
        }

        switch ($this->idc_type) {
        case "none": 
        case "self":
            return $this->_add($this->mc_list[0], $key, $value, $expire);
        case "all":
            $ret_all = false;
            foreach($this->mc_list as $mc) {
                $ret_all |= $this->_add($mc, $key, $value, $expire);
            }
            return $ret_all;
        default:
            $this->_warning("idc_type[$idc_type] error");
        }
    }

    public function get($key) {
        switch ($idc_type) {
        case "none": 
        case "self":
            return $this->mc_list[0]->get($key);
        case "all":
            foreach($this->mc_list as $mc) {
                $ret = $mc->add($key, $value, $expire);
                if ($ret == false) {
                    _warning("get key[$key] error", $mc);
                } else {
                    return $ret;
                }
            }
            return false;
        default:
            $this->_warning("idc_type[$idc_type] error");
        }
    }

    public function delete($key) {
    }

    public function addChild($main_key, $sub_key, $value, $expire = null) {
    }

    public function getChild($main_key, $sub_key) {
    }

    public function deleteChild($main_key, $sub_key) {
    }

    function _warning($str, $mc = false) {
        if (is_object($mc)) {
            $mc_msg = $mc->getResultMessage();
            $str .= ", memcached result[$mc_msg]"; 
        }

        $func = @$this->conf['warning_func'];
        if (!is_callable($func)) {
            throw new Exception($str);
        }
        call_user_func($func, array($str));
    }
    
}




/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
