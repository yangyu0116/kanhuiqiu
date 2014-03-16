<?php
/***************************************************************************
 * 
 * Copyright (c) 2011 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
 
 
 
/**
 * @file demo/test_schema.php
 * @author wangweibing(com@baidu.com)
 * @date 2011/05/16 11:16:07
 * @brief 
 *  
 **/

require_once(dirname(__FILE__) . "/../Schema.class.php");

function log_error($str) {
    echo $str . "\n";
}

Ak_Error::setHandler('log_error');

function user_check_func(&$arr) {
    return true;
}

$struct = array(
    'user_id' => array(
        'base' => 'int',
        'min' => 0,
        'max' => 100,
        'default' => 1,
    ),
    'user_ip' => array(
        'base' => 'int',
        'in' => array(1, 4, 6),
        'optional' => true,
    ),
    'user2' => array(
        'base' => 'user_id',
        'min' => 2,
        'max' => 4,
        'default' => 2,
    ),
    'user_name' => array(
        'base' => 'string',
        'min_size' => 5,
        'max_size' => 10,
        'regex' => '/\d+abc/',
    ),
    'user_xxx' => array(
        'base' => 'multi',
        'types' => array('user_id', 'user_name'),
    ),
    'rate' => array(
        'base' => 'float',
        'min' => 0.1,
        'max' => 0.5,
    ),
    'list' => array(
        'base' => 'array',
        'item_type' => 'user_id',
        'min_size' => 1,
        'max_size' => 3,
    ),
    'dic' => array(
        'base' => 'dict',
        'key_type' => 'string',
        'value_type' => 'user_id',
        'min_size' => 1,
        'max_size' => 2,
    ),
    'obj' => array(
        'base' => 'object',
        'members' => array(
            'user_id' => 'user_id',
            'is_a' => 'bool',
        ),
        'alias' => array(
            'uid' => 'user_id',
        ),
    ),
    'obj2' => array(
        'base' => 'obj',
        'member' => array(
            'ext' => 'string',
        ),
        'user_def' => 'user_check_func',
    ),
    'anything' => array(
        'base' => 'any',
    ),
);

$interface = array(
    'func' => array(
        'params' => array('user_id','user_ip'),
        'return' => 'int'
    ),
    'func2' => array(
        'params' => array('user_id'),
        'return' => 'int'
    ),
);

function test($schema, $type, $value) {
    $ret = $schema->validate($type, $value);
    var_dump($ret);
    var_dump($value);
}

$schema = Ak_Schema::create($struct);

test($schema, 'user_xxx', -10);
/*
test($schema, 'user_id', null);
test($schema, 'user_id', 10);
test($schema, 'user_ip', 4);
test($schema, 'user_ip', null);
test($schema, 'user2', null);
test($schema, 'user_name', '13222abc');
test($schema, 'rate', 0.1);
test($schema, 'list', array(2, null));
test($schema, 'dic', array('a' => 2, 'b' => null));
test($schema, 'obj', array('uid' => null, 'is_a' => true));
test($schema, 'obj2', array('uid' => 2, 'is_a' => true, 'ext' => ''));
test($schema, 'anything', array());
 */



/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
