<?php
/***************************************************************************
 * 
 * Copyright (c) 2010 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/



/**
 * @file scheduler/genericscheduler.class.php
 * @author liuqingjun(com@baidu.com)
 * @date 2010/10/25 16:55:07
 * @brief 
 *  
 **/

require_once(dirname(__FILE__)."/../frame/scheduler.class.php");

abstract class AClientGenericScheduler extends AClientScheduler {

    protected $CHOOSE_NUM = 1;        ///< 需要连接成功的资源个数

    //if could not connect to certain resource, how long should it be disabled?
    //in second
    protected $disabled_time = 10;//seconds

    //get the key of the disabled resource
    //to be used when storing it in cache
    protected function get_disable_key($res) {
        return 'AClientScheduler/Disabled/' . $res['ip'] . ':' . $res['port'];
    }

    //mark a resource as unusable
    protected function mark_unusable($res) {
        AClientUtils::set_key($this->get_disable_key($res), true, $this->disabled_time);
    }

    //check if a resource is usable
    protected function is_usable($res) {
        return AClientUtils::get_key($this->get_disable_key($res)) != true;
    }

    //check if an input is actually a resource
    protected function is_a_resource($resource) {
        return is_array($resource)
            && isset($resource['ip'])
            && isset($resource['port']);
    }

    //add a resource into the "resource list"
    protected function add_a_resource($resource) {
        if ($this->is_a_resource($resource)) {
            if ($this->is_usable($resource)) {
                $this->res[] = $resource;
                return true;
            }
        }
        return false;
    }

    //public interface
    //add resources to scheduler
    protected function add_resources($resources) {
        if (!is_array($resources)) {
            return false;
        }
        //eaccelerator_gc();
        if ($this->is_a_resource($resources)) {
            $this->add_a_resource($resources);
            return true;
        }
        foreach ($resources as $value) {
            $this->add_a_resource($value);
        }
        return true;
    }

    //to be called before choosing a resource
    //hook function
    protected function before_choose() {
        return;
    }

    //to be called after a resource has been chosen
    //hook function
    //input parameter is the chosen resource
    protected function after_chosen_resource($resource) {
        return;
    }

    public function process($protocol, $resources){
        if (empty($resources)) {
            AClientUtils::add_error("no resource");
            return false;
        }
        $this->res = array();
        $this->add_resources($resources);
        if (empty($this->res)) {
            AClientUtils::add_error("all resources are disabled");
            $this->res = $resources;
        }

        $this->before_choose();

        $count = 0;       ///<连接成功的个数  
        $success = false;

        foreach ($this->res as $res) {
            $ret = $protocol->process($res['ip'], $res['port']);
            if ($ret == AClientProtocol::$SUCCESS) {
                $success = true;
                $this->after_chosen_resource($res);
            } else {
                //still couldn't connect, mark this resource as unusable
                $this->mark_unusable($res);
            }

            if ($ret != AClientProtocol::$CONNECT_FAILED) {
                $count++;
            } 
            if ($this->CHOOSE_NUM > 0 && $count >= $this->CHOOSE_NUM) {
                break;
            }
        }

        return $success;
    }

    public function set_conf($conf){
        $gconf = AClient::$global_conf;
        if (isset($gconf['DisabledTime'])) {
            $this->disabled_time = $gconf['DisabledTime'];   
        }
        return true;
    }
}




/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
