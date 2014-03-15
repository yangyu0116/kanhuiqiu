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
    //û��escape�ַ�
    $encode_helper = new EncodeHelper();
    if( !isset($escape_string) || $escape_string=='' ){
        return $string;
    }
    $syntax_arr = explode(':',$escape_string);
    //�Ƿ��нض��﷨���xxx:length,����У������﷨��������
    $cutwordFlag = false;
    for( $j=0;$j<count($syntax_arr);$j++ ){
        if( $j!=0 ){
        	//�ҵ� xxx:������ʾ���н�ȡ���ԣ����������﷨
        	if( preg_match( '/^\d+$/', $syntax_arr[$j]) === 1 ){ 
        		unset( $syntax_real_arr );
        		$syntax_real_arr[] = intval($syntax_arr[$j]);
        		$cutwordFlag = true;
        		break;
        	}
            $syntax_real_arr[] = $syntax_arr[$j];
        }
    }
    
    //û���κ�ת�壬ֱ�����
    if( $syntax_real_arr==null || count($syntax_real_arr)==0 ){
       return $string;
    }
	//��ȡ����
	//echo "111string=$string<br>";
	if( $cutwordFlag === true ){
	    //echo "string=$string,length=".$syntax_real_arr[0]."<br>";
	    $string = $encode_helper->get_str_by_length($string,$syntax_real_arr[0], $etc);
	    return $string;
    }
    
	#ȡ���Ȳ���
	if( in_array('l', $syntax_real_arr) ){
		return strlen($string);
    }
    
    //�����utf8&&uת��,�Ƚ���utf8ת�壬�ٽ���urlת��
    if( in_array('utf8', $syntax_real_arr) && in_array('u',$syntax_real_arr) ){
    	return $encode_helper->utf8_url_encode($string);
    }
    //�����utf8����Ҫ��ʶ����ͼ�ַ������Ƚ���utf8ת�룬Ȼ�����ʵ���ַ�ת�룬�ٽ���urlת��
    if( in_array( 'utf8[entity]', $syntax_real_arr) && in_array('u',$syntax_real_arr) ){
        return $encode_helper->utf8_entity_url_encode($string);
    }
    //�����uת�壬����urlencodeת��
    if( in_array('u',$syntax_real_arr) ){
        return urlencode($string);
    }
    //h,j,x���У���j��h��ͬ
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
