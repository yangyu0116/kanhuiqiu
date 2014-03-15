<?php
/** 
 * @file GlobalCacheConfig.class.php
 * @brief GlobalCacheConfig
 * @author yangyu 
 * @date 2013-07-24
 * @desc ȫ�ֻ��������ļ�
 * @sample 
        '/^(\/$|\/\?)/' => array(						//URL·������ƥ��
				'NEW_INDEX_TEMPLATE' => array(			//cache ����, Ҫ��Ψһ
								'NEW_INDEX_TEMPLATE',	//cache key
								 600,					//����ʱ��
								 true,					//�Ƿ���
							),
 */
class GlobalCacheConfig {

	//ȫ������
	public static $config;
	
	//���뵱ǰ������
	public static $cache = array();

	//cache key�ָ���
	public static $cache_seq = '::';

	//���hash key��������
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
		//��ҳ
        '/^(\/$|\/\?)/' => array(
				//ҳ��ģ��
				'NEW_INDEX_TEMPLATE' => array(
								'NEW_INDEX_TEMPLATE',
								 600,
								 true,
							),
			   ),

);
