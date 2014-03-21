<?php
//Add  by yangyu@baidu.com	2013/03/22
class TimeFormatter {

	public static function timeFormatArr($sec) {
		if($sec < 60) {
			$retime = '00:'.$sec;
		}elseif($sec > 60 && $sec<3600) {
			$retime = str_pad(floor($sec/60), 2, '0', STR_PAD_LEFT).':'.str_pad($sec%60, 2, '0', STR_PAD_LEFT);
		}else{
			$retime = floor($sec/60).':'.str_pad($sec%60, 2, '0', STR_PAD_LEFT);
		}
		return $retime;
	}
}

?>