<?php
/** 
 * @file IndexAction.class.php
 * @brief ÊÓÆµÊ×Ò³action
 */

class IndexAction extends Action
{
    public function execute($context, $actionParam = null)
    {
        $timer = new Timer(true);
        $timer->start();

        $service = new IndexService();

        $hc_list = 0;
        $res_num_list = 0;
		$total_num = 0;
		$offset = 0;
        $video_list = $service->find_list($service, $offset, $res_num_list, $total_num, $hc_list);

        $urlparams = $context->getProperty('urlparams');


        $pager = new Pager($urlprefix, $res_num_index, $urlparams['pn'], $this->rn);
        $pagebar = $pager->get_html();


        // fill tpl variables        
        $this->tpl = SimpleTemplate::getInstance();
        $this->tpl->left_delimiter = "{%";
        $this->tpl->right_delimiter = "%}";
        $this->tpl->setTemplateDir("/home/video/channel/template/browse_template");

        $this->tpl->assign('css_path',CSS_PATH);
        $this->tpl->assign('img_path',IMAGE_PATH);
        $this->tpl->assign('host_path',HOST_PATH);
        $this->tpl->assign('baseurl',$context->getProperty('baseurl'));
        $this->tpl->assign('pagebar',$pagebar);
        $this->tpl->assign('total_num',$res_num_index);



        $this->tpl->show('page/index/index.tpl');

        $timer->stop();
        CLogger::notice('', 0, 
            array('action'=>'IndexAction', 'hc_index'=>$hc_index,
            'tt'=>$timer->getTotalTime()));
    }
}

?>
