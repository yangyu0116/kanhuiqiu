<?php
class SearchAction extends Action
{
	private function parse_url($context)
    {
		$urlparams = array();
		$request_uri = parse_url($_SERVER['REQUEST_URI']);
		parse_str($request_uri['query']);

		$urlparams['wd'] = urldecode($wd);
		$urlparams['wd'] = strlen($urlparams['wd']) > 24 ? substr($urlparams['wd'],0,24) : $urlparams['wd'];
		$urlparams['format'] = isset($format) ? strval($format) : '';
		$urlparams['callback'] = isset($callback) ? strval($callback) : '';
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
        $page_num = SearchConfig::$page_num;
		$total_num = 0;
		$offset = ($urlparams['p']-1)*$page_num;
        $video_list = $service->find_list($urlparams, $offset, $page_num, $total_num, $hc_search);

		if ($urlparams['format'] == 'json'){
			echo StringTool::gen_jsonp($video_list, $urlparams['callback']);
			exit;
		}

		$urlprefix = '/s?wd='.$urlparams['wd'];
		//$total_pn = ceil($total_num/$page_num);
        $pager = new Pager($urlprefix, $total_num, $urlparams['p'], $page_num);
        $pagebar = $pager->get_html();

        $tpl = SimpleTemplate::getInstance();

		//$tpl->setTemplateDir(TEMPLATE_PATH);
        //$tpl->assign('baseurl',$context->getProperty('baseurl'));
        $tpl->assign('pagebar',$pagebar);
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
