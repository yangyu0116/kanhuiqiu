<?php
class SearchAction extends Action
{
	
	private function parse_url($context)
    {
		$urlparams = array();
		$request_uri = parse_url($_SERVER['REQUEST_URI']);
		parse_str($request_uri['query']);

		$urlparams['wd'] = urldecode($wd);
		$urlparams['p'] = isset($p) ? max($p,1) : 1;
		
		$context->setProperty('urlparams', $urlparams);
	}

    public function execute($context, $actionParam = null)
    {
        $timer = new Timer(true);
        $timer->start();

		$this->parse_url($context);
        $urlparams = $context->getProperty('urlparams');

        $service = new SearchService();

        $hc_search = 0;
        $res_num_list = SearchConfig::$page_num;
		$total_num = 0;
		$offset = ($urlparams['p']-1)*$res_num_list;
        $video_list = $service->find_list($urlparams, $offset, $res_num_list, $total_num, $hc_search);


        //$pager = new Pager($urlprefix, $res_num_search, $urlparams['pn'], $this->rn);
        //$pagebar = $pager->get_html();

        $tpl = SimpleTemplate::getInstance();

		//$tpl->setTemplateDir(TEMPLATE_PATH);
        //$tpl->assign('baseurl',$context->getProperty('baseurl'));
        //$tpl->assign('pagebar',$pagebar);
        $tpl->assign('total_num',$total_num);
		$tpl->assign('wd',$urlparams['wd']);
		

		$tpl->assign('video_list',$video_list);
        $tpl->show(SearchConfig::$tpl_name);
		
        $timer->stop();
        CLogger::notice('', 0, 
            array('action'=>'SearchAction', 'hc_search'=>$hc_search,
            'tt'=>$timer->getTotalTime()));
    }
}

?>
