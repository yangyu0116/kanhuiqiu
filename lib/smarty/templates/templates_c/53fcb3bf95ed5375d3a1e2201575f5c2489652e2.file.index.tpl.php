<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:27
         compiled from "/home/video/channel/template/browse_template/page/index/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1733236639532a3adb5fc6f6-51895595%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '53fcb3bf95ed5375d3a1e2201575f5c2489652e2' => 
    array (
      0 => '/home/video/channel/template/browse_template/page/index/index.tpl',
      1 => 1377251507,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1733236639532a3adb5fc6f6-51895595',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pageS' => 0,
    'index_hot_focus' => 0,
    'index_hot_more' => 0,
    'index_top_search' => 0,
    'channelLinkConf' => 0,
    'tabConfKindsBar' => 0,
    'tabConf_mainMovie' => 0,
    'headConf_mainMovie' => 0,
    'pageTn' => 0,
    'tabConfMovieTop' => 0,
    'tabConf_mainTV' => 0,
    'headConf_mainTV' => 0,
    'tabConfTvTop' => 0,
    'tabConf_mainTamasha' => 0,
    'headConf_mainTamasha' => 0,
    'index_top_tamasha' => 0,
    'tabConf_mainCartoon' => 0,
    'headConf_mainCartoon' => 0,
    'index_top_cartoon' => 0,
    'tabConf_mainMini' => 0,
    'headConf_mainMini' => 0,
    'index_top_mini' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adbb1e6f',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adbb1e6f')) {function content_532a3adbb1e6f($_smarty_tpl) {?><?php if (!is_callable('smarty_function_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/function.widget.php';
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<!--STATUS OK-->
<html>
<head>

<meta content="text/html; charset=gb2312" http-equiv="Content-Type">
<meta http-equiv="X-UA-Compatible" content="IE=7">
<meta content="百度视频搜索是全球最大的中文视频搜索引擎，拥有最多的中文视频资源，提供用户最完美的观看体验。在百度视频，您可以便捷地找到最新、最热的互联网视频，更有丰富的视频榜单、多样的视频专题满足您不同的视频观看需求。百度视频，你的视界。" name="description">
<title>百度视频搜索——全球最大中文视频搜索引擎</title>

<?php echo smarty_function_widget(array('path'=>"widget/common/base_js/base_js.tpl"),$_smarty_tpl);?>

<?php echo smarty_function_widget(array('path'=>"widget/common/framework_static/framework_static.tpl"),$_smarty_tpl);?>

<?php echo smarty_function_widget(array('path'=>"widget/common/module_static/module_static.tpl"),$_smarty_tpl);?>

<?php echo smarty_function_widget(array('path'=>"widget/index/module_static/module_static.tpl"),$_smarty_tpl);?>

<script type="text/javascript">F._fileMap({'/browse_static/index/index/index_00249cbd.js' : ['__virsul__']});F.use('__virsul__');</script><link href="/browse_static/index/index/index_80e34d28.css" rel="stylesheet" type="text/css"/>

</head>
<body>
<?php $_smarty_tpl->tpl_vars['pageS'] = new Smarty_variable("1600", null, 0);?>
<?php $_smarty_tpl->tpl_vars['pageTn'] = new Smarty_variable("index", null, 0);?>
<?php $_smarty_tpl->tpl_vars['channelLinkConf'] = new Smarty_variable(array(), null, 0);?>
<?php $_smarty_tpl->createLocalArrayVariable('channelLinkConf', null, 0);
$_smarty_tpl->tpl_vars['channelLinkConf']->value["movie"] = "/movieindex/";?>
<?php $_smarty_tpl->createLocalArrayVariable('channelLinkConf', null, 0);
$_smarty_tpl->tpl_vars['channelLinkConf']->value["tvplay"] = "/tvplayindex/";?>
<?php $_smarty_tpl->createLocalArrayVariable('channelLinkConf', null, 0);
$_smarty_tpl->tpl_vars['channelLinkConf']->value["tamasha"] = "/tamashaindex/";?>
<?php $_smarty_tpl->createLocalArrayVariable('channelLinkConf', null, 0);
$_smarty_tpl->tpl_vars['channelLinkConf']->value["cartoon"] = "/cartoonindex/";?>

    <?php echo smarty_function_widget(array('path'=>"widget/common/userbar/userbar.tpl"),$_smarty_tpl);?>

    <div id="main">
        <?php echo smarty_function_widget(array('path'=>"widget/common/searchbox/searchbox.tpl"),$_smarty_tpl);?>

        
        <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['pageS']->value;?>
<?php $_tmp1=ob_get_clean();?><?php echo smarty_function_widget(array('path'=>"widget/common/navbar/navbar.tpl",'current'=>"index",'s'=>$_tmp1),$_smarty_tpl);?>

        
        <div id="focus" class="chan-sec">
            <div class="sec-main">
                <?php echo smarty_function_widget(array('path'=>"widget/index/hotvideo/hotvideo.tpl",'data'=>$_smarty_tpl->tpl_vars['index_hot_focus']->value),$_smarty_tpl);?>

				<?php echo smarty_function_widget(array('path'=>"widget/index/morehot/morehot.tpl",'data'=>$_smarty_tpl->tpl_vars['index_hot_more']->value['videos']),$_smarty_tpl);?>

            </div>
            <div class="sec-aside">
	       		<div class="mod mod-aside">
					<div class="hd">
            			<h3>热门搜索排行榜</h3>
					</div>
					<div class="bd">
						<?php echo smarty_function_widget(array('path'=>"widget/common/toplist/toplist.tpl",'data'=>$_smarty_tpl->tpl_vars['index_top_search']->value['videos'],'id'=>"index_top_search_list"),$_smarty_tpl);?>

					</div>
				</div>
			</div>
		</div>

		<div id="kindsBar" class="chan-sec">
                <?php $_smarty_tpl->tpl_vars['tabConfKindsBar'] = new Smarty_variable(array(), null, 0);?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConfKindsBar', null, 0);
$_smarty_tpl->tpl_vars['tabConfKindsBar']->value[0] = array('name'=>'电影','url'=>$_smarty_tpl->tpl_vars['channelLinkConf']->value["movie"],'tpl'=>'kinds-movie','data'=>array('index_kinds_movie_planA','index_kinds_movie_planB'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConfKindsBar', null, 0);
$_smarty_tpl->tpl_vars['tabConfKindsBar']->value[1] = array('name'=>'电视剧','url'=>$_smarty_tpl->tpl_vars['channelLinkConf']->value["tvplay"],'tpl'=>'kinds-tv','data'=>array('index_kinds_tv_planA','index_kinds_tv_planB'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConfKindsBar', null, 0);
$_smarty_tpl->tpl_vars['tabConfKindsBar']->value[2] = array('name'=>'综艺','url'=>$_smarty_tpl->tpl_vars['channelLinkConf']->value["tamasha"],'tpl'=>'kinds-tvshow','data'=>array('index_kinds_tvshow'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConfKindsBar', null, 0);
$_smarty_tpl->tpl_vars['tabConfKindsBar']->value[3] = array('name'=>'动漫','url'=>$_smarty_tpl->tpl_vars['channelLinkConf']->value["cartoon"],'tpl'=>'kinds-cartoon','data'=>array('index_kinds_cartoon'));?>			
                <?php echo smarty_function_widget(array('path'=>"widget/index/kindsbar/kindsbar.tpl",'conf'=>$_smarty_tpl->tpl_vars['tabConfKindsBar']->value),$_smarty_tpl);?>

		</div>
         
		<?php echo smarty_function_widget(array('path'=>"widget/index/picarea_firstscreen/picarea_firstscreen.tpl"),$_smarty_tpl);?>

		<?php echo smarty_function_widget(array('path'=>"widget/index/picarea_normal/picarea_normal.tpl"),$_smarty_tpl);?>

		<?php echo smarty_function_widget(array('path'=>"widget/index/picarea_landscape/picarea_landscape.tpl"),$_smarty_tpl);?>

		
        <div id="secMovie" class="chan-sec">
            <div class="sec-main" monkey="index_show_movie">
				<?php $_smarty_tpl->tpl_vars['headConf_mainMovie'] = new Smarty_variable(array('title'=>'电影','url'=>$_smarty_tpl->tpl_vars['channelLinkConf']->value["movie"],'morelink'=>$_smarty_tpl->tpl_vars['channelLinkConf']->value["movie"]), null, 0);?>
				
                <?php $_smarty_tpl->tpl_vars['tabConf_mainMovie'] = new Smarty_variable(array(), null, 0);?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainMovie', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainMovie']->value[0] = array('name'=>'热门','tpl'=>"picarea_firstscreen",'limit'=>false,'url'=>'http://v.baidu.com/movie/?s=tebietuijian1&complete=%D5%FD%C6%AC','data'=>array('index_show_movie_hot','index_show_movie_more'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainMovie', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainMovie']->value[1] = array('name'=>'爱情','tpl'=>"picarea_normal",'limit'=>false,'url'=>'http://v.baidu.com/movie/?director=&actor=&type=%B0%AE%C7%E9&area=&pn=1&order=hot&complete=%D5%FD%C6%AC','data'=>array('index_show_movie_love'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainMovie', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainMovie']->value[2] = array('name'=>'喜剧','tpl'=>"picarea_normal",'limit'=>false,'url'=>'http://v.baidu.com/movie/?director=&actor=&type=%CF%B2%BE%E7&area=&pn=1&order=hot&complete=%D5%FD%C6%AC','data'=>array('index_show_movie_comic'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainMovie', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainMovie']->value[3] = array('name'=>'动作','tpl'=>"picarea_normal",'limit'=>false,'url'=>'http://v.baidu.com/movie/?director=&actor=&type=%B6%AF%D7%F7&area=&pn=1&order=hot&complete=%D5%FD%C6%AC','data'=>array('index_show_movie_action'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainMovie', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainMovie']->value[4] = array('name'=>'伦理','tpl'=>"picarea_normal",'limit'=>false,'url'=>'http://v.baidu.com/movie/?director=&actor=&type=%C2%D7%C0%ED&area=&pn=1&order=hot&complete=%D5%FD%C6%AC','data'=>array('index_show_movie_ethic'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainMovie', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainMovie']->value[5] = array('name'=>'恐怖','tpl'=>"picarea_normal",'limit'=>false,'url'=>'http://v.baidu.com/movie/?director=&actor=&type=%BF%D6%B2%C0&area=&pn=1&order=hot&complete=%D5%FD%C6%AC','data'=>array('index_show_movie_horror'));?>
				
				<?php echo smarty_function_widget(array('path'=>"widget/common/tabpicarea/tabpicarea.tpl",'id'=>"index_show_movie",'tabConf'=>$_smarty_tpl->tpl_vars['tabConf_mainMovie']->value,'headConf'=>$_smarty_tpl->tpl_vars['headConf_mainMovie']->value),$_smarty_tpl);?>

           </div>
            <div class="sec-aside">
                <div class="mod mod-aside" static="s=<?php echo $_smarty_tpl->tpl_vars['pageS']->value;?>
&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&bl=index_top_movie" monkey="index_top_movie">
                    <div class="hd">
                        <h3>电影热搜榜</h3>
                        <a class="anchor-more" href="http://v.baidu.com/topmovie/" target="_blank" static="stp=mo">更多&gt;&gt;</a>
                    </div>
                    <?php $_smarty_tpl->tpl_vars['tabConfMovieTop'] = new Smarty_variable(array(), null, 0);?>
                    <?php $_smarty_tpl->createLocalArrayVariable('tabConfMovieTop', null, 0);
$_smarty_tpl->tpl_vars['tabConfMovieTop']->value[0] = array('name'=>'全部','url'=>'http://v.baidu.com/topmovie/','data'=>'index_top_movie_all');?>
                    <?php $_smarty_tpl->createLocalArrayVariable('tabConfMovieTop', null, 0);
$_smarty_tpl->tpl_vars['tabConfMovieTop']->value[1] = array('name'=>'美国','url'=>'http://v.baidu.com/topmovie/?area=%C3%C0%B9%FA','data'=>'index_top_movie_USA');?>
                    <?php $_smarty_tpl->createLocalArrayVariable('tabConfMovieTop', null, 0);
$_smarty_tpl->tpl_vars['tabConfMovieTop']->value[2] = array('name'=>'韩国','url'=>'http://v.baidu.com/topmovie/?area=%BA%AB%B9%FA','data'=>'index_top_movie_Korea');?>
                    <?php $_smarty_tpl->createLocalArrayVariable('tabConfMovieTop', null, 0);
$_smarty_tpl->tpl_vars['tabConfMovieTop']->value[3] = array('name'=>'香港','url'=>'http://v.baidu.com/topmovie/?area=%CF%E3%B8%DB','data'=>'index_top_movie_HK');?>
                    <?php $_smarty_tpl->createLocalArrayVariable('tabConfMovieTop', null, 0);
$_smarty_tpl->tpl_vars['tabConfMovieTop']->value[4] = array('name'=>'内地','url'=>'http://v.baidu.com/topmovie/?area=%C4%DA%B5%D8','data'=>'index_top_movie_China');?>
                    <?php echo smarty_function_widget(array('path'=>"widget/common/tabtoplist/tabtoplist.tpl",'conf'=>$_smarty_tpl->tpl_vars['tabConfMovieTop']->value,'id'=>"index_top_movie",'count'=>13),$_smarty_tpl);?>

                </div>
            </div>
        </div>

        <div id="secTV" class="chan-sec">
            <div class="sec-main" monkey="index_show_tv">
				<?php $_smarty_tpl->tpl_vars['headConf_mainTV'] = new Smarty_variable(array('title'=>'电视剧','url'=>$_smarty_tpl->tpl_vars['channelLinkConf']->value["tvplay"],'morelink'=>$_smarty_tpl->tpl_vars['channelLinkConf']->value["tvplay"]), null, 0);?>
				
                <?php $_smarty_tpl->tpl_vars['tabConf_mainTV'] = new Smarty_variable(array(), null, 0);?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainTV', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainTV']->value[0] = array('name'=>'热门','tpl'=>"picarea_firstscreen",'limit'=>false,'url'=>'http://v.baidu.com/tvplay/','data'=>array('index_show_tv_hot','index_show_tv_more'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainTV', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainTV']->value[1] = array('name'=>'青春偶像','tpl'=>"picarea_normal",'limit'=>false,'url'=>'http://v.baidu.com/tvplay/?type=%C7%E0%B4%BA%C5%BC%CF%F1','data'=>array('index_show_tv_idol'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainTV', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainTV']->value[2] = array('name'=>'情感','tpl'=>"picarea_normal",'limit'=>false,'url'=>'http://v.baidu.com/tvplay/?type=%C7%E9%B8%D0','data'=>array('index_show_tv_emotion'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainTV', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainTV']->value[3] = array('name'=>'喜剧','tpl'=>"picarea_normal",'limit'=>false,'url'=>'http://v.baidu.com/tvplay/?type=%CF%B2%BE%E7','data'=>array('index_show_tv_comic'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainTV', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainTV']->value[4] = array('name'=>'古装','tpl'=>"picarea_normal",'limit'=>false,'url'=>'http://v.baidu.com/tvplay/?type=%B9%C5%D7%B0','data'=>array('index_show_tv_ancient'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainTV', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainTV']->value[5] = array('name'=>'家庭伦理','tpl'=>"picarea_normal",'limit'=>false,'url'=>'http://v.baidu.com/tvplay/?type=%BC%D2%CD%A5%C2%D7%C0%ED','data'=>array('index_show_tv_ethic'));?>
                
				<?php echo smarty_function_widget(array('path'=>"widget/common/tabpicarea/tabpicarea.tpl",'id'=>"index_show_tv",'tabConf'=>$_smarty_tpl->tpl_vars['tabConf_mainTV']->value,'headConf'=>$_smarty_tpl->tpl_vars['headConf_mainTV']->value),$_smarty_tpl);?>

           </div>
           <div class="sec-aside">
                <div class="mod mod-aside" static="s=<?php echo $_smarty_tpl->tpl_vars['pageS']->value;?>
&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&bl=index_top_tv" monkey="index_top_tv">
                    <div class="hd">
                        <h3>电视剧热搜榜</h3>
                        <a class="anchor-more" href="http://v.baidu.com/toptvplay/" target="_blank" static="stp=mo">更多&gt;&gt;</a>
                    </div>
                    <?php $_smarty_tpl->tpl_vars['tabConfTvTop'] = new Smarty_variable(array(), null, 0);?>
                    <?php $_smarty_tpl->createLocalArrayVariable('tabConfTvTop', null, 0);
$_smarty_tpl->tpl_vars['tabConfTvTop']->value[0] = array('name'=>'全部','url'=>'http://v.baidu.com/toptvplay/','data'=>'index_top_tv_all');?>
                    <?php $_smarty_tpl->createLocalArrayVariable('tabConfTvTop', null, 0);
$_smarty_tpl->tpl_vars['tabConfTvTop']->value[1] = array('name'=>'内地','url'=>'http://v.baidu.com/toptvplay/?area=%C4%DA%B5%D8','data'=>'index_top_tv_China');?>
                    <?php $_smarty_tpl->createLocalArrayVariable('tabConfTvTop', null, 0);
$_smarty_tpl->tpl_vars['tabConfTvTop']->value[2] = array('name'=>'韩国','url'=>'http://v.baidu.com/toptvplay/?area=%BA%AB%B9%FA','data'=>'index_top_tv_Korea');?>
                    <?php $_smarty_tpl->createLocalArrayVariable('tabConfTvTop', null, 0);
$_smarty_tpl->tpl_vars['tabConfTvTop']->value[3] = array('name'=>'香港','url'=>'http://v.baidu.com/toptvplay/?area=%CF%E3%B8%DB','data'=>'index_top_tv_HK');?>
                    <?php $_smarty_tpl->createLocalArrayVariable('tabConfTvTop', null, 0);
$_smarty_tpl->tpl_vars['tabConfTvTop']->value[4] = array('name'=>'台湾','url'=>'http://v.baidu.com/toptvplay/?area=%CC%A8%CD%E5','data'=>'index_top_tv_Taiwan');?>
                    <?php echo smarty_function_widget(array('path'=>"widget/common/tabtoplist/tabtoplist.tpl",'conf'=>$_smarty_tpl->tpl_vars['tabConfTvTop']->value,'id'=>"index_top_tv",'count'=>13),$_smarty_tpl);?>

                </div>
            </div>
        </div>
         
        <div id="secTamasha" class="chan-sec">
            <div class="sec-main" monkey="index_show_tamasha">
				<?php $_smarty_tpl->tpl_vars['headConf_mainTamasha'] = new Smarty_variable(array('title'=>'综艺','url'=>$_smarty_tpl->tpl_vars['channelLinkConf']->value["tamasha"],'morelink'=>$_smarty_tpl->tpl_vars['channelLinkConf']->value["tamasha"]), null, 0);?>
				
                <?php $_smarty_tpl->tpl_vars['tabConf_mainTamasha'] = new Smarty_variable(array(), null, 0);?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainTamasha', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainTamasha']->value[0] = array('name'=>'热门','tpl'=>"picarea_normal",'url'=>'http://v.baidu.com/tvshow/','limit'=>5,'data'=>array('index_show_tamasha_hot','index_show_tamasha_more'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainTamasha', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainTamasha']->value[1] = array('name'=>'大陆','tpl'=>"picarea_normal",'url'=>'http://v.baidu.com/tvshow/?area=%B4%F3%C2%BD','limit'=>5,'data'=>array('index_show_tamasha_China'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainTamasha', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainTamasha']->value[2] = array('name'=>'港台','tpl'=>"picarea_normal",'url'=>'http://v.baidu.com/tvshow/?area=%B8%DB%CC%A8','limit'=>5,'data'=>array('index_show_tamasha_HKTaiwan'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainTamasha', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainTamasha']->value[3] = array('name'=>'日韩','tpl'=>"picarea_normal",'url'=>'http://v.baidu.com/tvshow/?area=%C8%D5%BA%AB','limit'=>5,'data'=>array('index_show_tamasha_JapanKorea'));?>
				
				<?php echo smarty_function_widget(array('path'=>"widget/common/tabpicarea/tabpicarea.tpl",'id'=>"index_show_tamasha",'tabConf'=>$_smarty_tpl->tpl_vars['tabConf_mainTamasha']->value,'headConf'=>$_smarty_tpl->tpl_vars['headConf_mainTamasha']->value),$_smarty_tpl);?>

           </div>
            <div class="sec-aside">
                <div class="mod mod-aside">
                    <div class="hd" static="s=<?php echo $_smarty_tpl->tpl_vars['pageS']->value;?>
&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&bl=index_top_tamasha_list" monkey="index_top_tamasha_list">
                        <h3>综艺热搜榜</h3>
                        <a class="anchor-more" href="http://v.baidu.com/toptvshow/" target="_blank" static="stp=mo">更多&gt;&gt;</a>
                    </div>
					<div class="bd">
						<?php echo smarty_function_widget(array('path'=>"widget/common/toplist/toplist.tpl",'data'=>$_smarty_tpl->tpl_vars['index_top_tamasha']->value['videos'],'id'=>"index_top_tamasha_list",'count'=>6),$_smarty_tpl);?>

					</div>
                </div>
            </div>
        </div>
         
        <div id="secCartoon" class="chan-sec">
            <div class="sec-main" monkey="index_show_cartoon">
				<?php $_smarty_tpl->tpl_vars['headConf_mainCartoon'] = new Smarty_variable(array('title'=>'动漫','url'=>$_smarty_tpl->tpl_vars['channelLinkConf']->value["cartoon"],'morelink'=>$_smarty_tpl->tpl_vars['channelLinkConf']->value["cartoon"]), null, 0);?>
				
                <?php $_smarty_tpl->tpl_vars['tabConf_mainCartoon'] = new Smarty_variable(array(), null, 0);?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainCartoon', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainCartoon']->value[0] = array('name'=>'热门','tpl'=>"picarea_normal",'url'=>'http://v.baidu.com/comic/','limit'=>5,'data'=>array('index_show_cartoon_hot','index_show_cartoon_more'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainCartoon', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainCartoon']->value[1] = array('name'=>'日本','tpl'=>"picarea_normal",'url'=>'http://v.baidu.com/comic/?area=%C8%D5%B1%BE','limit'=>5,'data'=>array('index_show_cartoon_Japan'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainCartoon', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainCartoon']->value[2] = array('name'=>'国产','tpl'=>"picarea_normal",'url'=>'http://v.baidu.com/comic/?area=%B9%FA%B2%FA','limit'=>5,'data'=>array('index_show_cartoon_China'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainCartoon', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainCartoon']->value[3] = array('name'=>'欧美','tpl'=>"picarea_normal",'url'=>'http://v.baidu.com/comic/?area=%C5%B7%C3%C0','limit'=>5,'data'=>array('index_show_cartoon_occident'));?>
				
				<?php echo smarty_function_widget(array('path'=>"widget/common/tabpicarea/tabpicarea.tpl",'id'=>"index_show_cartoon",'tabConf'=>$_smarty_tpl->tpl_vars['tabConf_mainCartoon']->value,'headConf'=>$_smarty_tpl->tpl_vars['headConf_mainCartoon']->value),$_smarty_tpl);?>

           </div>
            <div class="sec-aside">
                <div class="mod mod-aside" static="s=<?php echo $_smarty_tpl->tpl_vars['pageS']->value;?>
&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&bl=index_top_cartoon_list" monkey="index_top_cartoon_list">
                    <div class="hd">
                        <h3>动漫热搜榜</h3>
                        <a class="anchor-more" href="http://v.baidu.com/topcomic/" target="_blank" static="stp=mo">更多&gt;&gt;</a>
                    </div>
					<div class="bd">
						<?php echo smarty_function_widget(array('path'=>"widget/common/toplist/toplist.tpl",'data'=>$_smarty_tpl->tpl_vars['index_top_cartoon']->value['videos'],'id'=>"index_top_cartoon_list",'count'=>6),$_smarty_tpl);?>

					</div>
                </div>
            </div>
        </div>
         
        <div id="secMini" class="chan-sec">
            <div class="sec-main" monkey="index_show_mini">
                <?php $_smarty_tpl->tpl_vars['headConf_mainMini'] = new Smarty_variable(array('title'=>'视频广场','url'=>false,'morelink'=>false), null, 0);?>
				
                <?php $_smarty_tpl->tpl_vars['tabConf_mainMini'] = new Smarty_variable(array(), null, 0);?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainMini', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainMini']->value[0] = array('name'=>'热门','tpl'=>"picarea_landscape",'limit'=>false,'url'=>'','data'=>array('index_show_mini_hot'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainMini', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainMini']->value[1] = array('name'=>'音乐MV','tpl'=>"picarea_landscape",'limit'=>false,'url'=>'http://v.baidu.com/childchannal/videomv/videomv.html','data'=>array('index_show_mini_music'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainMini', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainMini']->value[2] = array('name'=>'自拍搞笑','tpl'=>"picarea_landscape",'limit'=>false,'url'=>'http://v.baidu.com/childchannal/amuse/amuse.html','data'=>array('index_show_mini_comic'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainMini', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainMini']->value[3] = array('name'=>'美女明星','tpl'=>"picarea_landscape",'limit'=>false,'url'=>'http://v.baidu.com/childchannal/stars/woman.html','data'=>array('index_show_mini_beauty'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainMini', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainMini']->value[4] = array('name'=>'相声小品','tpl'=>"picarea_landscape",'limit'=>false,'url'=>'http://v.baidu.com/childchannal/xiaopin/xiaopin.html','data'=>array('index_show_mini_playlet'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainMini', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainMini']->value[5] = array('name'=>'资讯','tpl'=>"picarea_landscape",'limit'=>false,'url'=>'http://v.baidu.com/childchannal/info/info.html','data'=>array('index_show_mini_info'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainMini', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainMini']->value[6] = array('name'=>'体育','tpl'=>"picarea_landscape",'limit'=>false,'url'=>'http://v.baidu.com/childchannal/sport/sport.html','data'=>array('index_show_mini_sport'));?>
                <?php $_smarty_tpl->createLocalArrayVariable('tabConf_mainMini', null, 0);
$_smarty_tpl->tpl_vars['tabConf_mainMini']->value[7] = array('name'=>'游戏','tpl'=>"picarea_landscape",'limit'=>false,'url'=>'http://v.baidu.com/childchannal/game/game.html','data'=>array('index_show_mini_game'));?>
                 
				
				<?php echo smarty_function_widget(array('path'=>"widget/common/tabpicarea/tabpicarea.tpl",'id'=>"index_show_mini",'tabConf'=>$_smarty_tpl->tpl_vars['tabConf_mainMini']->value,'headConf'=>$_smarty_tpl->tpl_vars['headConf_mainMini']->value),$_smarty_tpl);?>

           </div>
            <div class="sec-aside">
                <div class="mod mod-aside">
                    <div class="hd">
                        <h3>今日最热</h3>
                    </div>
					<div class="bd">
						<?php echo smarty_function_widget(array('path'=>"widget/common/toplist/toplist.tpl",'data'=>$_smarty_tpl->tpl_vars['index_top_mini']->value['videos'],'id'=>"index_top_mini_list"),$_smarty_tpl);?>

					</div>
                </div>
            </div>
        </div>
         

        <?php echo smarty_function_widget(array('path'=>"widget/common/footer/footer.tpl"),$_smarty_tpl);?>

    </div>
<?php echo smarty_function_widget(array('path'=>"widget/common/statistics/statistics.tpl",'id'=>"video-index-2012-q2sa0"),$_smarty_tpl);?>

<img src="http://nsclick.baidu.com/p.gif?pid=104&u=http%3A%2F%2Fvideo.baidu.com%2F?sa=5&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
" style="display:none" />
</body>
</html>
<?php }} ?>