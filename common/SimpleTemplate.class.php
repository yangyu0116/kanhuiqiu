<?php
 /** 
 * @file SimpleTemplate.class.php
 * @brief 
 * 对Smarty模板的简单封装。
 */
class SimpleTemplate extends Smarty
{   
    private static $__instance;

    public static function getInstance()
    {
        if(empty($__instance)){
            $__instance = new SimpleTemplate();
        }
        return $__instance;
    }

    public function __construct()
    { 
        //@caution
        //必须调用父类构造函数，才能使smarty自动加载机制生效
        parent::__construct();

        $this->template_dir = SMARTY_TEMPLATE_DIR;
        $this->compile_dir = SMARTY_COMPILE_DIR;
        $this->config_dir = SMARTY_CONFIG_DIR;
        $this->cache_dir = SMARTY_CACHE_DIR;
        $this->left_delimiter='{%';
        $this->right_delimiter='%}';
        
        $this->compile_check = true;
        $this->caching = false;
    }

    public function get_prompt($data = null)
    {
        //传入模版数据
        if (array_key_exists('HTTP_BAIDU_USER_AGENT', $_SERVER)) {
            if (preg_match('/Might-Be-360/', $_SERVER['HTTP_BAIDU_USER_AGENT'], $groups)) {
                //It should be changed to TRUE when needed. by qiuhao01
                return false;
                //return true;
            }
        }
        return false;
    }

    public function show($tpl_name, $data = null)
    {
        //传入模版数据
        if (is_array($data))
        {
            foreach ($data as $key => $value) 
            {
                $this->assign($key, $value);
            }
        }
		/*
        //抽样配置
        if (array_key_exists($tpl_name, SampleConfig::$SAMPLE_CONFIG)) 
        {
            if (isset($_GET['sa'])) {
                $sa = intval($_GET['sa']);
                $rate = $sa % 100; 
            } else {
                if (array_key_exists('BAIDUID', $_COOKIE)) {
                    $rate = StringTool::sample_rate($_COOKIE['BAIDUID']); 
                } else {
                    $rate = 50;
                }
            }
            foreach (SampleConfig::$SAMPLE_CONFIG[$tpl_name] as $conf_item) 
            {
                if($rate < $conf_item['rate'])
                {
                    CLogger::debug(sprintf('hit sample rate[%d] src[%s] dest[%s]', $rate, $tpl_name, $conf_item['tpl']));
                    switch ($conf_item['type']) 
                    {
                        case SAMPLE_TYPE_STATIC: 
                            header('Location: '.$conf_item['tpl']);
                            return ;
                        case SAMPLE_TYPE_SMARTY:
                            $this->display($conf_item['tpl']); 
                            return ;
                        default:
                            CLogger::warning('unknow sample type', -1, array('type' => $conf_item['type']));
                            break;
                    }
                } 
            }
        }
		*/
        
        //非抽样，直接显示
        $this->display($tpl_name); 
    }

    public function show2($tpl_name, $service, $config, &$hc, $data = null)
    {
        //传入模版数据
        if (is_array($data))
        {
            foreach ($data as $key => $value) 
            {
                $this->assign($key, $value);
            }
        }

        //抽样配置
        if (array_key_exists($tpl_name, SampleConfig::$SAMPLE_CONFIG)) 
        {
            if (isset($_GET['sa'])) {
                $sa = intval($_GET['sa']);
                $rate = $sa % 100; 
            } else {
                if (array_key_exists('BAIDUID', $_COOKIE)) {
                    $rate = StringTool::sample_rate($_COOKIE['BAIDUID']); 
                } else {
                    $rate = 50;
                }
            }
            foreach (SampleConfig::$SAMPLE_CONFIG[$tpl_name] as $conf_item) 
            {
                if($rate < $conf_item['rate'])
                {
                    CLogger::debug(sprintf('hit sample rate[%d] src[%s] dest[%s]', $rate, $tpl_name, $conf_item['tpl']));
                    switch ($conf_item['type']) 
                    {
                        case SAMPLE_TYPE_STATIC: 
                            header('Location: '.$conf_item['tpl']);
                            return ;
                        case SAMPLE_TYPE_SMARTY:
                            $arrData = $service->fetch_cache_get($config);
                            //命中cache
                            if ($arrData !== false) {
                                $hc = 1;
                                echo($arrData);
                                return ;
                            } else {
                                $output = $this->fetch($conf_item['tpl']);
                                $service->fetch_cache_set($config, $output);
                                echo($output);
                                return ;
                            }

                        default:
                            CLogger::warning('unknow sample type', -1, array('type' => $conf_item['type']));
                            break;
                    }
                } 
            }
        }
        
        //非抽样，直接显示
        $this->display($tpl_name); 
    } 

}
?>
