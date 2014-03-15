<?php
/***************************************************************************
 * 
 * Copyright (c) 2010 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
 
 
 
/**
 * @file source/galileo.class.php
 * @author wangweibing(com@baidu.com)
 * @date 2010/12/10 17:57:34
 * @brief 
 *  
 **/

class AClientGalileo extends AClientSource {
    protected $zk_host;
    protected $zk_backup_path;
    protected $zk_backup_file;
    protected $zk_update_time;
    protected $zk_path;

    function get_res_from_zk(){
        $zk = new zookeeper($this->zk_host);
        $ppath = $this->zk_path;
        for($i = 0; $i < 10; $i++){
            $val = @$zk->get($ppath);
            if(substr($val, 0, 2) == '->'){
                $ppath = substr($val, 2);
            }
            else{
                break;
            }
        }
        $children = @$zk->getChildren($ppath);
        if(!is_array($children)){
            AClientUtils::add_error("zookeeper get children failed, path[$ppath] host[$this->zk_host]");
            return null;
        }
        sort($children);

        $res = array();
        foreach($children as $child){
            $path = $ppath.'/'.$child;
            $json = @$zk->get($path);
            if(empty($json)){
                AClientUtils::add_error("zookeeper get data failed path[$path]");
                continue;
            }

            $val = json_decode($json, true);
            if(!is_array($val)){
                AClientUtils::add_error("zookeeper data format wrong, path[$path] data[$json]");
                continue;
            }

            if(isset($val['Port'])){
                $val['port'] = $val['Port'];
                unset($val['Port']);
            }
            $res[] = $val;
        }
        return $res;
    }

    public function set_conf($conf){
        $this->zk_path = $conf['Path'];

        $gconf = &AClient::$global_conf;
        $this->zk_update_time = @(int)$gconf['ZookeeperUpdateTime'];
        if($this->zk_update_time <= 0){
            $this->zk_update_time = 5;
        }

        $this->zk_host = $gconf['ZookeeperHost'];
        if(is_array($this->zk_host)){
            $this->zk_host = implode(',', $this->zk_host);
        }

        $path = @$gconf['ZookeeperBackupPath'];
        if(empty($path)){
            $path = dirname(__FILE__)."/../var/";
        }
        if(!file_exists($path)){
            mkdir($path);
        }
        if(!is_dir($path)){
            return false;
        }
        $this->zk_backup_path = $path;
        $this->zk_backup_file = str_replace('/', '_', $this->zk_path);
        return true;
    }

    public function get_resources(){
        $key = 'AClientGalileo/ZKData/'.$this->zk_path;
        $res = AClientUtils::get_key($key);
        if(!empty($res)){
            return $res;
        }

        $fd = fopen($this->zk_backup_path.'/zk_lock', 'a+b');
        if (!flock($fd, LOCK_EX)) {
            return null;
        }

        $res = AClientUtils::get_key($key);
        if(empty($res)) {
            $res = $this->get_res_from_zk();
            if(!empty($res)){
                AClientUtils::dump_to_file($res, $this->zk_backup_file, $this->zk_backup_path);
            } 
            else{
                $res = AClientUtils::retrieve_from_file($this->zk_backup_file, $this->zk_backup_path);
            }

            if(!empty($res)){
                AClientUtils::set_key($key, $res, $this->zk_update_time);
            }
            else {
                $res = null;
            }
        }

        flock($fd, LOCK_UN);
        fclose($fd);

        return $res;
    }
}




/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
