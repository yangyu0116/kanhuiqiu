<?php
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
        parent::__construct();

        $this->template_dir = SMARTY_TEMPLATE_DIR;
        $this->compile_dir = SMARTY_COMPILE_DIR;
        $this->config_dir = SMARTY_CONFIG_DIR;
        $this->cache_dir = SMARTY_CACHE_DIR;
        $this->left_delimiter='{%';
        $this->right_delimiter='%}';

		$this->assign('CSS_PATH', CSS_PATH);
        $this->assign('IMAGE_PATH', IMAGE_PATH);
		$this->assign('JS_PATH', JS_PATH);
        
        $this->compile_check = true;
        $this->caching = false;
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

        $this->display($tpl_name); 
    }


}
?>
