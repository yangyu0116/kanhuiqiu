<?php
/***************************************************************************
 * 
 * Copyright (c) 2010 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/



/**
 * @file functions.php
 * @author liuqingjun(com@baidu.com)
 * @date 2010/09/06 17:38:37
 * @brief 
 *  
 **/

/**
 * dump $var to filename, can be retrieved using retreve_from_file
 */
if (!defined('MIN_PORT')) {
    define('MIN_PORT', 1025);
}
if (!defined('MAX_PORT')) {
    define('MAX_PORT', 65535);
}

define('SRC_PATH', ROOT_PATH.'/phpsrc/');

//if the class is not found, this will try to
//load a php file according to the class name
function __autoload($cls) {
    $file=SRC_PATH.strtolower($cls).'.class.php';
    require_once($file);
}

function error_exit($err_no) {
    header("HTTP/1.1 500 Internal Error");
    echo 'an error occurred, error number is:'.$err_no;
    exit();
}

function log_debug($str) {
    $str=str_replace("%","%%",$str);
    UB_LOG_DEBUG($str);
}
function log_warning($str) {
    $str=str_replace("%","%%",$str);
    UB_LOG_WARNING($str);
}
function log_fatal($str) {
    $str=str_replace("%","%%",$str);
    UB_LOG_FATAL($str);
}

//function for user authentication
function authenticate($users, $u, $p, $ip) {
    if ((!isset($users[$u]))
        || (!isset($users[$u]['tk']))
        || ($users[$u]['tk'] != '*' && $users[$u]['tk'] !== $p)) {
            return false;
        }
    if (isset($users[$u]['ip'])) {
        if (is_array($users[$u]['ip'])) {
            foreach ($users[$u]['ip'] as $range) {
                if (is_ip_in_range($ip, $range)) {
                    return true;
                }
            }
            return false;
        } else {
            return is_ip_in_range($ip, $users[$u]['ip']);
        }
    }
    return true;
}

//function to find suitable resources
/*
function find_resources($resources, $service) {
    $ret = array();
    foreach ($resources as $r) {
        if ($service->resource_match($r)) {
            $ret[] = $r;
        }
    }
    return $ret;
}
 */
//function to check the format of the config file
function check_conf() {
    global $users, $resources, $service;

    //regexes to match ip range
    $ip_range_regex = '/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(?:\/(?:(?:3[0-2])|[1-2]?[0-9]))?$/';
    $ip_regex = '/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/';

    $ret = true;

    if (!isset($users) || !is_array($users)) {
        log_warning("users not set or format error");
        $ret = false;
    } else {
        foreach ($users as $_pid => $_data) {
            if (!isset($_data['tk'])) {
                log_warning("tk not set for pid $_pid");
                $ret = false;
            }
            if (!isset($_data['ip'])) {
                log_warning("ip not set for pid $_pid");
                $ret = false;
            } else {
                if (is_array($_data['ip'])){
                    foreach ($_data['ip'] as $_key => $_range) {
                        if (preg_match($ip_range_regex, $_range) == 0) {
                            log_warning("ip range error for pid $_pid ip[$_key] $_range");
                            $ret = false;
                        }
                    }
                } else {
                    if (preg_match($ip_range_regex, $_data['ip']) == 0) {
                        log_warning("ip range error for pid $_pid ip {$_data['ip']}");
                        $ret = false;
                    }
                }
            }
        }
    }

    if (!isset($resources) || !is_array($resources)){
        //log_warning("resources not set or format error");
        //$ret = false;
    } else {
        foreach ($resources as $_index => $_data) {
            if (!isset($_data['ip'])) {
                log_warning("ip not set in resources[$_index]");
                $ret = false;
            } else if (preg_match($ip_regex, $_data['ip']) == 0) {
                log_warning("ip error in resources[$_index]");
                $ret = false;
            }
            if (!is_int($_data['port']) || $_data['port'] < MIN_PORT || $_data['port'] > MAX_PORT) {
                log_warning("port error in resources[$_index]");
                $ret = false;
            }
        }
    }

    //TODO check other parts of config file

    if (!class_exists($service->protocol) || !is_subclass_of($service->protocol, 'Protocol')) {
        log_warning("class {$service->protocol} not exist or not a subclass of class Protocol");
    }

    return $ret;
}


/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
