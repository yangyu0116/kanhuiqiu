<?php
/** 
 * @file IndexAction.class.php
 * @brief 篇撞遍匈action
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
//！！！！！！！！！！！！！！！！debug！！！！！！！！！！！！！！！！！！！！！！！！！！
echo '<pre>';
var_dump ($video_list);
echo '</pre>';
exit();
//！！！！！！！！！！！！！！！！debug！！！！！！！！！！！！！！！！！！！！！！！！！！

        $pager = new Pager($urlprefix, $res_num_index, $urlparams['pn'], $this->rn);
        $pagebar = $pager->get_html();


        // fill tpl variables        
        $this->tpl = SimpleTemplate::getInstance();

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
