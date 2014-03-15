<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty cmsescape modifier plugin
 *
 * Type:     modifier<br>
 * Name:     cmsescape<br>
 * Purpose:  Escape the string according to escapement type
 * @link http://smarty.php.net/manual/en/language.modifier.escape.php
 *          escape (Smarty online manual)
 * @author   chenggang
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_cmsescape($string, $escape_string, $etc= "...")
{
    //echo "escape=$escape_string<br>";
    //echo "*****string=$string,gbk string=".var_export(iconv('utf-8','gbk',$string),true)."<br>";
    //var_dump($string);
    //var_dump(iconv('utf-8','gbk',$string));
    //echo iconv("utf-8",'gbk',$string);
    //没有escape字符
    $encode_helper = new EncodeHelper();
    if( !isset($escape_string) || $escape_string=='' ){
        return $string;
    }
    $syntax_arr = explode(':',$escape_string);
    //是否有截断语法标记xxx:length,如果有，其他语法都不处理
    $cutwordFlag = false;
    for( $j=0;$j<count($syntax_arr);$j++ ){
        if( $j!=0 ){
        	//找到 xxx:整数标示，有截取属性，忽略其他语法
        	if( preg_match( '/^\d+$/', $syntax_arr[$j]) === 1 ){ 
        		unset( $syntax_real_arr );
        		$syntax_real_arr[] = intval($syntax_arr[$j]);
        		$cutwordFlag = true;
        		break;
        	}
            $syntax_real_arr[] = $syntax_arr[$j];
        }
    }
    
    //没有任何转义，直接输出
    if( $syntax_real_arr==null || count($syntax_real_arr)==0 ){
       return $string;
    }
	//截取操作
	//echo "111string=$string<br>";
	if( $cutwordFlag === true ){
	    //echo "string=$string,length=".$syntax_real_arr[0]."<br>";
	    $string = $encode_helper->get_str_by_length($string,$syntax_real_arr[0], $etc);
	    return $string;
    }
    
	#取长度操作
	if( in_array('l', $syntax_real_arr) ){
		return strlen($string);
    }
    
    //如果有utf8&&u转义,先进行utf8转义，再进行url转义
    if( in_array('utf8', $syntax_real_arr) && in_array('u',$syntax_real_arr) ){
    	return $encode_helper->utf8_url_encode($string);
    }
    //如果有utf8并且要求识别试图字符，则先进行utf8转码，然后进行实体字符转码，再进行url转义
    if( in_array( 'utf8[entity]', $syntax_real_arr) && in_array('u',$syntax_real_arr) ){
        return $encode_helper->utf8_entity_url_encode($string);
    }
    //如果有u转义，进行urlencode转义
    if( in_array('u',$syntax_real_arr) ){
        return urlencode($string);
    }
    //h,j,x都有，与j，h相同
    if( in_array('h',$syntax_real_arr) && in_array('x',$syntax_real_arr) && in_array('j',$syntax_real_arr) ){
        return $encode_helper->js_html_encode($string);
    }
    //h,x=x
    if( (in_array('h',$syntax_real_arr) && in_array('x',$syntax_real_arr))  ){
        return $encode_helper->xml_encode($string);
    }
    //h,j
    if( in_array('h',$syntax_real_arr) && in_array('j',$syntax_real_arr) ){
        return $encode_helper->js_html_encode($string);
    }
    //x,j=j
    if( (in_array('x',$syntax_real_arr) && in_array('j',$syntax_real_arr)) ){
        return $encode_helper->js_encode($string);
    }
    //h
    if( in_array('h',$syntax_real_arr) ){
        return $encode_helper->html_encode($string);
    }	        
    //j
    if( in_array('j',$syntax_real_arr) ){
        return $encode_helper->js_encode($string);
    }
    //x
    if( in_array('x',$syntax_real_arr) ){
        return $encode_helper->xml_encode($string);
    }
    //v
    if( in_array('v',$syntax_real_arr) ){
        return $encode_helper->onclick_encode($string);
    }
    
    return $string;
}

/* vim: set expandtab: */

?>
