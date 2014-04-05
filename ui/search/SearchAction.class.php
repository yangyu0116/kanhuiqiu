<?php
/** 
 * @file SearchAction.class.php
 * @brief 视频首页action
 */

class SearchAction extends Action
{
	
	private function parse_url($context)
    {
		$urlparams = array();
		$request_uri = parse_url($_SERVER['REQUEST_URI']);
		parse_str($request_uri['query']);

		$urlparams['wd'] = $wd;
		
		$context->setProperty('urlparams', $urlparams);
	}

    public function execute($context, $actionParam = null)
    {
        $timer = new Timer(true);
        $timer->start();

        $context->setProperty('urlparams', $urlparams);
		$this->parse_url($context);
        $urlparams = $context->getProperty('urlparams');

        $service = new SearchService();


        $hc_list = 0;
        $res_num_list = 0;
		$total_num = 0;
		$offset = 0;
        $video_list = $service->find_list($urlparams, $offset, $res_num_list, $total_num, $hc_list);

        $urlparams = $context->getProperty('urlparams');


        $pager = new Pager($urlprefix, $res_num_search, $urlparams['pn'], $this->rn);
        $pagebar = $pager->get_html();

//————————————————debug——————————————————————————
echo '<pre>';
print_r ($video_list);
echo '</pre>';
exit();
//————————————————debug——————————————————————————
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
