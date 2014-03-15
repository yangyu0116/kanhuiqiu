<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty truncate modifier plugin for gbk
 * 修正中文截取乱码问题 by xuzhaoyuan
 *
 * Type:     modifier<br>
 * Name:     truncate<br>
 * Purpose:  Truncate a string to a certain length if necessary,
 *           optionally splitting in the middle of a word, and
 *           appending the $etc string or inserting $etc into the middle.
 * @link http://smarty.php.net/manual/en/language.modifier.truncate.php
 *          truncate (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param integer
 * @param string
 * @param boolean
 * @param boolean
 * @return string
 */
function smarty_modifier_truncate_gbk($string, $len = 100, $etc = '...')
{        
    $string = strval($string);
    if (strlen($string) <= $len) {
        return $string;
    }
    $strCut = '';
    $etcCount = ($etc == '' ? 0 : 2); 
    //$etcCount = 1; 
    for ($i=0; $i < $len; $i++) {
        if ( ord($string{$i}) > 0x80 ) {
            ++ $i;
            if ($i >= $len - $etcCount) break;
            $strCut .= $string{$i - 1} . $string{$i};
        } else {
            if ($i >= $len - $etcCount) break;
            $strCut .= $string{$i};
        }
    }
    return $strCut . $etc;
}

/* vim: set expandtab: */

?>
