<?php
/***************************************************************************
 * 
 * Copyright (c) 2010 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
 
 
 
/**
 * @file aclient.class.php
 * @author wangweibing(com@baidu.com)
 * @date 2010/12/09 18:03:45
 * @brief 
 *  
 **/

require_once(dirname(__FILE__)."/utils/utils.php");
require_once(dirname(__FILE__)."/frame/source.class.php");
require_once(dirname(__FILE__)."/frame/protocol.class.php");
require_once(dirname(__FILE__)."/frame/scheduler.class.php");


class AClient {
    public static $global_conf = null;

    private $source = null;
    private $protocol = null;
    private $scheduler = null;
    private $ready = false; 
    private $error = null;

    function create_obj_from_conf($type, $conf){
        $name = $conf[$type];
        $file = dirname(__FILE__).strtolower("/$type/$name.class.php");
        $obj = AClientUtils::create_obj('AClient'.$name, 'AClient'.$type, $file);
        if($obj == null){
            AClientUtils::add_error("can not create $type $name");
            return null;
        }

        $ret = $obj->set_conf(@$conf[$name."Conf"]);
        if($ret != true){
            AClientUtils::add_error("$name Conf no correct");
            return null;
        }
        return $obj;
    }

    function _call($input){
        if($this->ready != true){
            AClientUtils::add_error('no available conf');
            return null;
        }

        $resources = $this->source->get_resources();
        if(empty($resources)){
            AClientUtils::add_error('no resource');
            return null;
        }

        $ret = $this->protocol->set_input($input);
        if($ret != true){
            AClientUtils::add_error('input format wrong');
            return null;
        }

        $ret = $this->scheduler->process($this->protocol,$resources);
        if($ret != true){
            AClientUtils::add_error('process failed');
            return null;
        }

        return $this->protocol->get_output();
    }

    function set_conf($conf){
        $this->ready = false;

        $this->protocol = $this->create_obj_from_conf('Protocol', $conf);
        if($this->protocol == null){
            return false;
        }

        $this->source = $this->create_obj_from_conf('Source', $conf);
        if($this->source == null){
            return false;
        }

        $this->scheduler = $this->create_obj_from_conf('Scheduler', $conf);
        if($this->scheduler == null){
            return false;
        }

        $this->ready = true;
        return true;
    }

    public function Call($input){
        AClientUtils::clear_error();
        $output = $this->_call($input);
        $this->error = AClientUtils::get_error();
        return $output;
    }

    public function SetConf($conf){
        AClientUtils::clear_error();
        $ret = $this->set_conf($conf);
        $this->error = AClientUtils::get_error();
        return $ret;
    }

    public function GetLastError(){
        return $this->error;
    }

    public static function SetGlobalConf($conf){
        self::$global_conf=$conf;
    }
}




/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
