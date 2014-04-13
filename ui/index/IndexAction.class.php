<?php
class IndexAction extends Action
{
    public function execute($context, $actionParam = null)
    {
        $timer = new Timer(true);
        $timer->start();

		$userinfo = Session::check_login();

		$user_service = new UserService();
		$search_list = $user_service->find_user_search_list($userinfo['uid']);

		if ($search_list == false){

			$index_service = new IndexService();
			$video_list = $index_service->recommend_list();

		}else{
			
			$search_service = new SearchService();
			$video_list = $search_service->find_list_by_array($search_list);

		}


        $urlparams = $context->getProperty('urlparams');


        //$pager = new Pager($urlprefix, $res_num_index, $urlparams['pn'], $this->rn);
        //$pagebar = $pager->get_html();

 
        $tpl = SimpleTemplate::getInstance();

        //$this->tpl->assign('baseurl',$context->getProperty('baseurl'));
        //$this->tpl->assign('pagebar',$pagebar);
        //$this->tpl->assign('total_num',$res_num_index);

		$tpl->assign('video_list',$video_list);
        $tpl->show(IndexConfig::$tpl_name);

        $timer->stop();
        CLogger::notice('', 0, 
            array('action'=>'IndexAction', 'hc_index'=>$hc_index,
            'tt'=>$timer->getTotalTime()));
    }
}

