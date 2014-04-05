<?php
/** 
 * @file GlobalCacheConfig.class.php
 * @brief GlobalCacheConfig
 * @author yangyu 
 * @date 2013-07-24
 * @desc 全局缓存配置文件
 * @sample 
        '/^(\/$|\/\?)/' => array(						//URL路径正则匹配
				'NEW_INDEX_TEMPLATE' => array(			//cache 索引, 要求唯一
								'NEW_INDEX_TEMPLATE',	//cache key
								 600,					//过期时间
								 true,					//是否开启
							),
 */
class GlobalCacheConfig {

	//全局配置
	public static $config;
	
	//载入当前的配置
	public static $cache = array();

	//cache key分隔符
	public static $cache_seq = '::';

	//针对hash key进行适配
	public static function create_key(){
		
		if (func_num_args() < 2){
			return false;
		}

		$cache_pre = func_get_arg(0);
		if (!isset(GlobalCacheConfig::$cache[$cache_pre])){
			GlobalCacheConfig::$cache[$cache_pre] = array(
					$cache_pre,
					300,
					true,
			);
		}
		$args = func_get_args();
		array_shift($args);
		$current_cache_pre = GlobalCacheConfig::$cache[$cache_pre][0];
		$current_cache_pre = substr($current_cache_pre, 0, strpos($current_cache_pre,self::$cache_seq)).self::$cache_seq;

		if (is_array($args[0]) && count($args) == 1){
			GlobalCacheConfig::$cache[$cache_pre][0] = $current_cache_pre.$args[0][0];
		}else{
			GlobalCacheConfig::$cache[$cache_pre][0] = $current_cache_pre.'('.implode(')(', $args).')';
		}
	}
}

GlobalCacheConfig::$config = array(
		//首页
        '/^(\/$|\/\?)/' => array(
				//页面模版
				'NEW_INDEX_TEMPLATE' => array(
								'NEW_INDEX_TEMPLATE',
								 600,
								 true,
							),
			   ),

);
