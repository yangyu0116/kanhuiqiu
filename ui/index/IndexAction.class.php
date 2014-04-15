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
		
		$rec_status = 0;

		if ($search_list == false){

			$index_service = new IndexService();
			$video_list = $index_service->recommend_list();

			$rec_status = 1;

		}else{
			
			$search_service = new SearchService();
			$video_list = $search_service->find_list_by_array($search_list);

		}


		if (strstr($_SERVER['REQUEST_URI'], 'db')){
			echo '<pre>';
			print_r ($video_list);
			echo '</pre>';
			exit;   //debug-------------------	
		}


        //$urlparams = $context->getProperty('urlparams');

        //$pager = new Pager($urlprefix, $res_num_index, $urlparams['pn'], $this->rn);
        //$pagebar = $pager->get_html();

 
        $tpl = SimpleTemplate::getInstance();

        //$tpl->assign('baseurl',$context->getProperty('baseurl'));
        //$tpl->assign('pagebar',$pagebar);
        //$ttpl->assign('total_num',$res_num_index);

		$tpl->assign('rec_status',$rec_status);
		$tpl->assign('video_list',$video_list);
        $tpl->show(IndexConfig::$tpl_name);

        $timer->stop();
        CLogger::notice('', 0, 
            array('action'=>'IndexAction', 'hc_index'=>0,
            'tt'=>$timer->getTotalTime()));
    }
}

