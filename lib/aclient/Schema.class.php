<?php
/***************************************************************************
 * 
 * Copyright (c) 2011 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
 
 
 
/**
 * @file Schema.class.php
 * @author wangweibing(com@baidu.com)
 * @date 2011/02/24 21:24:13
 * @brief 
 *  
 **/

require_once(dirname(__FILE__) . "/Error.class.php");

class Ak_Schema {
    protected $struct_def = null;

    protected function __construct() {}

    protected static function _isBasicType($type) {
        $basic_types = array('bool', 'int', 'float', 'string', 'array', 'dict', 'object', 'any', 'multi');
        return in_array($type, $basic_types, true);
    }

    protected static function _warning($str) {
        printf($str . "\n");
    }

    protected static function _checkRange($min, $max, $val) {
        if (isset($max) && $val > $max) {
            Ak_Error::report("value[$val] > max[$max]");
            return false;
        }
        if (isset($min) && $val < $min) {
            Ak_Error::report("value[$val] < min[$min]");
            return false;
        }
        return true;
    }

    public static function create($struct_def) {
        $struct_def_new = array();
        foreach($struct_def as $type => $def) {
            if (self::_isBasicType($type)) {
                Ak_Error::report("type[$type] is basic type");
                return null;
            }
            $base_list = array($type);
            while (!self::_isBasicType($def['base'])) {
                if (in_array($def['base'], $base_list)) {
                    Ak_Error::report("type[{$def['base']}] inherite recursively");
                    return null;
                }
                $base_list[] = $def['base'];

                $base_def = $struct_def[$def['base']];
                if (!is_array($base_def)) {
                    Ak_Error::report("type[{$def['base']}] not found");
                    return null;
                }
                if (!is_array($def['members'])) {
                    $def['members'] = array();
                }
                if (!is_array($def['alias'])) {
                    $def['alias'] = array();
                }

                foreach ($def as $k => $v) {
                    switch($k) {
                    case 'base':
                        $def[$k] = $base_def[$k];
                        break;
                    case 'members':
                    case 'alias':
                        if (!is_array($base_def[$k])) {
                            $base_def[$k] = array();
                        }
                        foreach ($base_def[$k] as $k2 => $v2) {
                            if (!isset($def[$k][$k2])) {
                                $def[$k][$k2] = $base_def[$k][$k2];
                            }
                        }
                        break;
                    default:
                        if (!isset($def[$k])) {
                            $def[$k] = $base_def[$k];
                        }
                    }
                }
            }
            $struct_def_new[$type] = $def;
        }
        $schema = new Ak_Schema();
        $schema->struct_def = $struct_def_new;
        return $schema;
    }


    public function validate($type, &$val) {
        if(self::_isBasicType($type)) {
            $def = array('base' => $type);
        } else {
            $def = @$this->struct_def[$type];
        }
        if(!is_array($def)) {
            Ak_Error::report("type[$type] not exists");
            return false;
        }

        //check if value is null
        if (is_null($val)) {
            if (isset($def['default'])) {
                $val = $def['default'];
            } elseif ($def['optional']) {
                return true;
            } else {
                Ak_Error::report("value is null");
                return false;
            } 
        }

        //check if value matches the type
        switch($def['base']) {
        case 'bool':
            if (!is_bool($val)) {
                Ak_Error::report("value[$val] is not bool");
                return false;
            }
            break;
        case 'int':
            if (!is_int($val)) {
                Ak_Error::report("value[$val] is not int");
                return false;
            }
            break;
        case 'float':
            if (!is_float($val)) {
                Ak_Error::report("value[$val] is not float");
                return false;
            }
            break;
        case 'string':
            if (!is_string($val)) {
                Ak_Error::report("value[$val] is not string");
                return false;
            }
            break;
        case 'array':
            if (!is_array($val)) {
                Ak_Error::report("value[$val] is not array");
                return false;
            }
            $i = 0;
            foreach ($val as $k => &$v) {
                if (!is_int($k) || $k != $i) {
                    Ak_Error::report("array index[$i] != key[$k]");
                    return false;
                }
                if (!$this->validate($def['item_type'], $v)) {
                    Ak_Error::report("item[$k] not valid");
                    return false;
                }
                $i++;
            }
            break;
        case 'dict':
            if (!is_array($val)) {
                Ak_Error::report("value[$val] is not dict");
                return false;
            }
            foreach ($val as $k => &$v) {
                if (!$this->validate($def['key_type'], $k)) {
                    Ak_Error::report("key[$k] is not type[{$def['key_type']}]");
                    return false;
                }
                if (!$this->validate($def['value_type'], $v)) {
                    Ak_Error::report("value[$v] is not type[{$def['value_type']}]");
                    return false;
                }
            }
            break;
        case 'object':
            if (!is_array($val) && !is_object($val)) {
                Ak_Error::report("value[$val] is not object");
                return false;
            }
            if (!is_array($def['alias'])) {
                $def['alias'] = array();
            }
            foreach ($def['alias'] as $k1 => $k2) {
                if (!isset($val[$k2])) {
                    $val[$k2] = $val[$k1];
                    unset($val[$k1]);
                }
            }
            foreach ($def['members'] as $k => $t) {
                if (!$this->validate($t, $val[$k])) {
                    Ak_Error::report("key[$k] is not type[$t]");
                    return false;
                }
            }
            break;
        case 'any':
            break;
        case 'multi':
            $ret_all = false;
            Ak_Error::pending();
            foreach ($def['types'] as $t) {
                $temp_val = $val;
                $ret = $this->validate($t, $temp_val);
                if ($ret != true) {
                    Ak_Error::report("value[$val] is not type[$t]");
                } else {
                    $val = $temp_val;
                    $ret_all = true;
                    break;
                }
            }
            if ($ret_all == true) {
                Ak_Error::finish(false);
            } else {
                Ak_Error::finish(true);
                return false;
            }
            break;
        default:
            Ak_Error::report("unknown type[{$def['base']}]");
            return false;
        }

        //check if value in the array
        if (is_array($def['in'])) {
            $ret = in_array($val, $def['in']);
            if ($ret != true) {
                Ak_Error::report("value[$val] not in array");
                return false;
            }
        }

        //check if the value in range
        switch ($def['base']) {
        case 'int':
        case 'float':
            if (!self::_checkRange(@$def['min'], @$def['max'], $val)) {
                Ak_Error::report("value[$val] is not valid");
                return false;
            }
            break;
        case 'string':
            $len = strlen($val);
            if (!self::_checkRange(@$def['min_size'], @$def['max_size'], $len)) {
                Ak_Error::report("string len[$len] is not valid");
                return false;
            }
            if (isset($def['regex']) && !preg_match($def['regex'], $val)) {
                Ak_Error::report("value[$val] not match regex[{$def['regex']}]");
                return false;
            }
            break;
        case 'array':
        case 'dict':
            $len = count($val);
            if (!self::_checkRange(@$def['min_size'], @$def['max_size'], $len)) {
                Ak_Error::report("item count[$len] is not valid");
                return false;
            }
            break;
        }

        //user defined check
        $func = @$def['user_def'];
        if (is_callable($func)) {
            $ret = $func($val);
            if ($ret != true) {
                Ak_Error::report("user check[$func] failed");
                return false;
            }
        }

        return true;
    }

}





/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
