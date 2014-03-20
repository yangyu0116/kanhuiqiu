<?php
/** 
 * @file SearchAction.class.php
 * @brief 篇撞遍匈action
 */

class SearchAction extends Action
{
    public function execute($context, $actionParam = null)
    {
        $timer = new Timer(true);
        $timer->start();

        $service = new SearchService();

        $hc_list = 0;
        $res_num_list = 0;
		$total_num = 0;
		$offset = 0;
        $video_list = $service->find_list($service, $offset, $res_num_list, $total_num, $hc_list);

        $urlparams = $context->getProperty('urlparams');


        $pager = new Pager($urlprefix, $res_num_search, $urlparams['pn'], $this->rn);
        $pagebar = $pager->get_html();

//！！！！！！！！！！！！！！！！debug！！！！！！！！！！！！！！！！！！！！！！！！！！
echo '<pre>';
print_r ($video_list);
echo '</pre>';
exit();
//！！！！！！！！！！！！！！！！debug！！！！！！！！！！！！！！！！！！！！！！！！！！
        // fill tpl variables        
        $tpl = SimpleTemplate::getInstance();

        $this->tpl->assign('baseurl',$context->getProperty('baseurl'));
        $this->tpl->assign('pagebar',$pagebar);
        $this->tpl->assign('total_num',$res_num_search);


        $this->tpl->show('page/search/search.tpl');

        $timer->stop();
        CLogger::notice('', 0, 
            array('action'=>'SearchAction', 'hc_search'=>$hc_search,
            'tt'=>$timer->getTotalTime()));
    }
}

?>
