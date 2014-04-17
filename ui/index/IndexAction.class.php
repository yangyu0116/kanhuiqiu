<?php
class IndexAction extends Action
{
	private function parse_url($context)
    {
		$urlparams = array();
		$wd = StringTool::get_param('wd');
		$urlparams['wd'] = empty($wd) ? '' : urldecode($wd);

		$context->setProperty('urlparams', $urlparams);
	}

    public function execute($context, $actionParam = null)
    {
        $timer = new Timer(true);
        $timer->start();

		$this->parse_url($context);
		$urlparams = $context->getProperty('urlparams');

		$userinfo = Session::check_login();

		$user_service = new UserService();
		$search_list = $user_service->find_user_search_list($userinfo['uid']);
		
		$rec_status = $valid_wd = 0;
		$video_list = array();

		if ($search_list == false){

			$index_service = new IndexService();
			$video_list = $index_service->recommend_list();
			$rec_status = 1;

		}else{
			
			if (!empty($urlparams['wd'])){
				foreach ($search_list as $search_wd){
					if ($search_wd['wd'] == $urlparams['wd']){
						$valid_wd = 1;
						break;
					}
				}
			}

			$search_service = new SearchService();

			if ($valid_wd == 1){

				$hc_search = 0;
				$page_num = SearchConfig::$page_num;
				$total_num = 0;
				$offset = 0;
				$wd_video_list = $search_service->find_list($urlparams, $offset, $page_num, $total_num, $hc_search);

				foreach ($search_list as $k => $s){
					$video_list[$k] = $s;
					$video_list[$k]['videos'] = ($s['wd']==$urlparams['wd']) ? $wd_video_list : array();
				}

			}else{

				$video_list = $search_service->find_list_by_array($search_list);

			}

		}


		if (isset($_GET['db'])){
			echo '<pre>';
			print_r ($video_list);
			echo '</pre>';
			exit;   //debug-------------------	
		}


        //$pager = new Pager($urlprefix, $res_num_index, $urlparams['pn'], $this->rn);
        //$pagebar = $pager->get_html();

 
        $tpl = SimpleTemplate::getInstance();

        //$tpl->assign('baseurl',$context->getProperty('baseurl'));
        //$tpl->assign('pagebar',$pagebar);
        //$ttpl->assign('total_num',$res_num_index);

		$tpl->assign('rec_status', $rec_status);
		$tpl->assign('valid_wd', $valid_wd);
		$tpl->assign('video_list', $video_list);
        $tpl->show(IndexConfig::$tpl_name);

        $timer->stop();
        CLogger::notice('', 0, 
            array('action'=>'IndexAction', 'hc_index'=>0,
            'tt'=>$timer->getTotalTime()));
    }
}

