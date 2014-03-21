<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:27
         compiled from "/home/video/channel/template/browse_template/widget/common/searchbox/searchbox.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2123972584532a3adbd8e768-40984252%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '862805883e06ceaed5de5d2348e0cf03d31c082e' => 
    array (
      0 => '/home/video/channel/template/browse_template/widget/common/searchbox/searchbox.tpl',
      1 => 1387615249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2123972584532a3adbd8e768-40984252',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pageS' => 0,
    'pageTn' => 0,
    'isBaidu' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adbdce79',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adbdce79')) {function content_532a3adbdce79($_smarty_tpl) {?><?php if (!is_callable('smarty_block_fis_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/block.fis_widget.php';
if (!is_callable('smarty_function_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/function.widget.php';
?><?php $_smarty_tpl->smarty->_tag_stack[] = array('fis_widget', array('isBaidu'=>1,'isNewSug'=>0)); $_block_repeat=true; echo smarty_block_fis_widget(array('isBaidu'=>1,'isNewSug'=>0), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<div class="vui newheader" monkey="newheader">
    <div class="l" static="s=<?php echo $_smarty_tpl->tpl_vars['pageS']->value;?>
&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&bl=newheader&stp=po">
        <a href="http://v.baidu.com"><img src="http://img.baidu.com/video/img/video_logo_new.gif" alt="百度视频"></a>
    </div>
    <div class="m">
        <div class="hd" id="tab_links" static="s=<?php echo $_smarty_tpl->tpl_vars['pageS']->value;?>
&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&bl=newheader&stp=ti">
            <a class="link" href="http://news.baidu.com/">新闻</a><a class="link" href="http://www.baidu.com/">网页</a><a class="link" href="http://tieba.baidu.com/">贴吧</a><a class="link" href="http://zhidao.baidu.com/">知道</a><a class="link" href="http://music.baidu.com/">音乐</a><a class="link" href="http://image.baidu.com/">图片</a><strong class="link">视频</strong><a class="link" href="http://map.baidu.com/">地图</a><a class="link"
            href="http://baike.baidu.com/">百科</a><a class="link" href="http://www.hao123.com/" target="_blank">hao123</a>
        </div>
		<?php echo smarty_function_widget(array('path'=>"widget/common/new_search/new_search.tpl",'isBaidu'=>$_smarty_tpl->tpl_vars['isBaidu']->value),$_smarty_tpl);?>

		<?php echo smarty_function_widget(array('path'=>"widget/common/searchKeyword/searchKeyword.tpl"),$_smarty_tpl);?>

    </div>
	<div class="r">
		<?php echo smarty_function_widget(array('path'=>"widget/common/bdv_record/bdv_record.tpl"),$_smarty_tpl);?>

		<a href="http://v.baidu.com/user/" class="link-user">个人中心</a>
	</div>
    <div class="promo-logo" static="s=<?php echo $_smarty_tpl->tpl_vars['pageS']->value;?>
&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&bl=promologo" videoadv="el=shoulder&page=index" monkey="common_top_02"></div>
</div>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fis_widget(array('isBaidu'=>1,'isNewSug'=>0), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>