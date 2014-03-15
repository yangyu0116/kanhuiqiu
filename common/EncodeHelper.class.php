<?php
class EncodeHelper{
    /*
    * js转义，将content中js字符转义
    * ' => \'
    * " => \"
    * \ => \\
    * \n => \n
    * \r => \r
    * 其中\n转义是将换行转义成\n字符，\r转义是将回车转义成\r字符
    */
    public function js_encode($content){
        $content = str_replace('\\','\\\\',$content);
        $content = str_replace('\'','\\\'',$content);
        $content = str_replace('"','\\"',$content);
        $content = str_replace("\n",'\\n',$content);
        $content = str_replace("\r",'\\r',$content);
        $content = str_replace('/', '\\/', $content);
        return $content;
    }

    /*
     *  xml转义，将content中xml字符转义
     *  < => &lt;
     *  > => &gt;
     *  & => &amp;
     *  ' => &#039;
     *  " => &quot;
     */
    public function xml_encode($content){
        $content = str_replace('&','&amp;',$content);
        $content = str_replace('<','&lt;',$content);
        $content = str_replace('>','&gt;',$content);
        $content = str_replace('\'','&#039;',$content);
        $content = str_replace('"','&quot;',$content);
    
        return $content;
    }

    public function onclick_encode( $content ){
    	$content = str_replace('\\','\\\\',$content);
    	$content = str_replace('&','&amp;',$content);
        $content = str_replace('<','&lt;',$content);
        $content = str_replace('>','&gt;',$content);       
        $content = str_replace('\'','\\&#039;',$content);
        $content = str_replace('"','\\&quot;',$content);
        $content = str_replace("\n",'\\n',$content);
        $content = str_replace("\r",'\\r',$content);     
        $content = str_replace('/', '\\/', $content);
        return $content;
    }

    /*
     *  html转义，将content中html字符转义
     *  < => &lt;
     *  > => &gt;
     *  ' => &#039;
     *  " => &quot;
     */
    public function html_encode($content){
        $content = str_replace('&','&amp;',$content);
        $content = str_replace('<','&lt;',$content);
        $content = str_replace('>','&gt;',$content);
        $content = str_replace('\'','&#039;',$content);
        $content = str_replace('"','&quot;',$content);
        return $content;
    }

    /*
     *  json+html转义，转义规则如下：
     * ' => \'
     * " => \"
     * \ => \\
     * \n => \n
     * \r => \r
     *  < => &lt;
     *  > => &gt;
     * 其中\n转义是将换行转义成\n字符，\r转义是将回车转义成\r字符
     */
    public function js_html_encode($content){
        $content = js_encode($content);
        $content = str_replace('<','&lt;',$content);
        $content = str_replace('>','&gt;',$content);
        return $content;
    }


    public function utf8_url_encode( $content ){
    	$content = iconv( "GBK", "UTF-8", $content );
    	$content = urlencode( $content );
    	return $content;
    }
    
    
    public function get_str_by_length( $title,$len,$etc='...' ){
    
        if( $len==null ){
            return $title;
        }
        $matches = array();
        $ret = preg_match_all('/&#[0-9]*;/',$title,$matches);
        if( $ret>0 ){
            $special_chars = $matches[0];
            for($i=0;$i<count($special_chars);$i++){
                $title = str_replace($special_chars[$i],chr(2)."$i",$title);
            }
            //lib_log("title22=$title");
        }
        if( strlen($title)<=$len ){
            if( $ret>0 ){
                for($j=0;$j<$i;$j++){
                    $title = str_replace(chr(2).$j,$special_chars[$j],$title);
                }
            }
            return $title;
        }
        $title = substr($title,0,$len);
        
        //lib_log("title23332=$title");
        if( $ret>0 ){
            for($j=0;$j<$i;$j++){
                $title = str_replace(chr(2).$j,$special_chars[$j],$title);
            }
        }
        $title = $this->filter_semi_char($title);
        $title.= $etc;
        return $title;
    
    }

	static function iconv_array_deep(&$value, $from_code = 'UTF-8', $to_code = 'GBK//IGNORE') {
        if (is_array ( $value )) {
            foreach ( $value as &$v ) {
                self::iconv_array_deep ($v, $from_code, $to_code);
            }
        } else {
				if (!strstr($to_code, '//IGNORE')){
					$to_code .= '//IGNORE';
				}
				if (empty($value)){
					return;
				}

				$value = @iconv($from_code, $to_code, $value);
		}
	}
    static function mb_convert_array_deep($value,$from_code = 'UTF-8', $to_code = 'GBK')
    {
        if(is_int($value))
        {
            return $value;
        }
        if(is_array($value))
        {
            $result=array();
            foreach($value as $k=>$v)
            {
                $result[$k]=self::mb_convert_array_deep($v,$from_code,$to_code);
            }
            return $result;
        }
        else
        {
            return mb_convert_encoding($value,$to_code,$from_code);
        }
    }


    public function filter_semi_char($str){
        if( strlen($str)==0 )
            return $str;
        $ret = true;
        $i=0;
        while($i<=strlen($str)){
            $temp_str = substr($str,$i,1);
            if( !eregi("[^\x80-\xff]","$temp_str") ){
                if( $i==strlen($str)-1 ){
                    $ret = false;
                }
                $i = $i+2;
            }
            else{
                $i++;
            }
        }
        if( $ret==false )
            $str = substr($str,0,-1);
        return $str;
    }
}
?>
