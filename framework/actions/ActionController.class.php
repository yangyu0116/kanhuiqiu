<?php /**
	 * a component of Action
	 *	
	 * ActionController is a controller which dispatches requests to
	 * some action that charge the logic or something else.
	 * Generally speaking, it is just the same as MVC's C.
	 * 
	 * @package bingo/framework
	 * @author  liubin01@baidu.com
     */

	class ActionController extends Action {

		protected $urlMapping;

		public function initial($initObject) {
			if (!is_array($initObject) || 0 >= count($initObject)) {
				CLogger::warning('ActionController initial failed',
								  GlobalConfig::BINGO_LOG_ERRNO,
								  array('initObject' => var_export($initObject, true)) 
				);
				return false;
			}
			$this->urlMapping = $initObject;
			return true;
		}
		public function execute($context, $actionParam = null) {
			$info = $this->__getDispatchActionInfo($context);
			if (!is_array($info)) {
				return false;
			}
			return $context->callAction($info[0]->actionID, $info[1]);	
		}
		private function __getDispatchActionInfo($context) {	
			if (array_key_exists('REQUEST_URI', $_SERVER)) {
				$url = $_SERVER['REQUEST_URI'];
			} else {
				$url = "";
			}
			foreach ($this->urlMapping as $pattern => $actionConfig) {
				if (preg_match($pattern, $url, $matches)) {		
					$action = $context->getAction($actionConfig[0],
							     	    		  $actionConfig[1],
                                                  $actionConfig[3]);
                    if(is_array($actionConfig[2]))
                    {
                        foreach($actionConfig[2] as $index => $key)
                        {
                            if(array_key_exists($index, $matches))
                            {
                                $_GET[$key] = $matches[$index];
                            }
                        }
                    }
					
					//����ȫ�ֻ������	yangyu@baidu.com
					if (isset(GlobalCacheConfig::$config[$pattern]))
					{
						GlobalCacheConfig::$cache = GlobalCacheConfig::$config[$pattern];
					}
					else
					{
						$global_cache_all = array();
						foreach (GlobalCacheConfig::$config as $cache_pattern => $cacheConfig)
						{
							if (preg_match($cache_pattern, $url, $cache_matches)) 
							{
								GlobalCacheConfig::$cache = GlobalCacheConfig::$config[$cache_pattern];
								break;
							}

							$global_cache_all = array_merge($global_cache_all, $cacheConfig);
						}

						if (empty(GlobalCacheConfig::$cache))
						{
							GlobalCacheConfig::$cache = $global_cache_all;
						}
						unset($global_cache_all);

					}

                    return array($action, $matches);
				}
			}
			CLogger::warning('ActionController does not have any dispatch action',
							  GlobalConfig::BINGO_LOG_ERRNO, 
							  array(
								'url' 		=> var_export($url, true),
								'actionID'	=> var_export($this->actionID, true)
						      )
			);
			return null;				
		}
	}
?>
