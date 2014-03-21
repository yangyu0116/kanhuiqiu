<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:28
         compiled from "/home/video/channel/template/browse_template/widget/index/hotvideo/hotvideo.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1202298381532a3adc0edd00-79117717%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd7b6b395392cb6cc0925e906f26551a3d60a5cdd' => 
    array (
      0 => '/home/video/channel/template/browse_template/widget/index/hotvideo/hotvideo.tpl',
      1 => 1377251509,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1202298381532a3adc0edd00-79117717',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pageS' => 0,
    'pageTn' => 0,
    'data' => 0,
    'count' => 0,
    'v' => 0,
    'imgWidth' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adc1d0f8',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adc1d0f8')) {function content_532a3adc1d0f8($_smarty_tpl) {?><?php if (!is_callable('smarty_block_fis_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/block.fis_widget.php';
if (!is_callable('smarty_modifier_f_escape_xml')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.f_escape_xml.php';
if (!is_callable('smarty_modifier_truncate_gbk')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.truncate_gbk.php';
?><?php $_smarty_tpl->smarty->_tag_stack[] = array('fis_widget', array('count'=>5)); $_block_repeat=true; echo smarty_block_fis_widget(array('count'=>5), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<?php $_smarty_tpl->tpl_vars['imgWidth'] = new Smarty_variable(498, null, 0);?>
<div id="hotVideo" class="" static="s=<?php echo $_smarty_tpl->tpl_vars['pageS']->value;?>
&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&bl=hotvideo" monkey="focus">
	<div class="tang-tab tang-ui">
	<ul class="tang-title">
	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['videos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['v']->iteration=0;
 $_smarty_tpl->tpl_vars['v']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['v']->iteration++;
 $_smarty_tpl->tpl_vars['v']->index++;
 $_smarty_tpl->tpl_vars['v']->first = $_smarty_tpl->tpl_vars['v']->index === 0;
?>	
		<?php if ($_smarty_tpl->tpl_vars['v']->index<$_smarty_tpl->tpl_vars['count']->value){?>	
		<li class="tang-title-item 
			<?php if ($_smarty_tpl->tpl_vars['v']->first){?>tang-title-item-first
			<?php }elseif($_smarty_tpl->tpl_vars['v']->index==$_smarty_tpl->tpl_vars['count']->value-1){?>tang-title-item-last<?php }?>"><a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
" target="_blank" hidefocus="true" static="stp=ti&no=<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['v']->iteration);?>
">
			<?php echo smarty_modifier_f_escape_xml(smarty_modifier_truncate_gbk($_smarty_tpl->tpl_vars['v']->value['s_intro'],24,''));?>

		</a></li>	
		<?php }?>	
	<?php } ?>	
	</ul>
	<ul class="tang-title-bg tang-body">
	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['videos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['v']->iteration=0;
 $_smarty_tpl->tpl_vars['v']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['v']->iteration++;
 $_smarty_tpl->tpl_vars['v']->index++;
 $_smarty_tpl->tpl_vars['v']->first = $_smarty_tpl->tpl_vars['v']->index === 0;
?>	
		<?php if ($_smarty_tpl->tpl_vars['v']->index<$_smarty_tpl->tpl_vars['count']->value){?>	
		<li class="tang-title-bg-item tang-body-item
			<?php if ($_smarty_tpl->tpl_vars['v']->first){?>tang-title-bg-item-first
			<?php }elseif($_smarty_tpl->tpl_vars['v']->index==$_smarty_tpl->tpl_vars['count']->value-1){?>tang-title-bg-item-last<?php }?>">
			&nbsp;	
		</li>	
		<?php }?>	
	<?php } ?>	
	</ul>
	</div>
	<div class="tang-img-container tang-content">
		<div class="tang-wrapper" style="width: <?php echo ($_smarty_tpl->tpl_vars['count']->value+3)*$_smarty_tpl->tpl_vars['imgWidth']->value;?>
px;">
		<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['videos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['v']->iteration=0;
 $_smarty_tpl->tpl_vars['v']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['v']->iteration++;
 $_smarty_tpl->tpl_vars['v']->index++;
 $_smarty_tpl->tpl_vars['v']->first = $_smarty_tpl->tpl_vars['v']->index === 0;
?>	
			<?php if ($_smarty_tpl->tpl_vars['v']->index<$_smarty_tpl->tpl_vars['count']->value){?>	
			<div class="tang-img-item" style="left:<?php echo ($_smarty_tpl->tpl_vars['v']->index)*$_smarty_tpl->tpl_vars['imgWidth']->value;?>
px">
				<a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
" target="_blank" static="stp=po&no=<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['v']->iteration);?>
">
					<img class="hot-video-img" src="<?php echo $_smarty_tpl->tpl_vars['v']->value['imgh_url'];?>
"/>
					<span class="update"><span><?php echo smarty_modifier_f_escape_xml(smarty_modifier_truncate_gbk($_smarty_tpl->tpl_vars['v']->value['title'],40,''));?>
</span>&nbsp;<i>[<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['v']->value['update']);?>
]</i></span>
					<span class="update-bg">&nbsp;</span>
				</a>
			</div>
			<?php }?>
		<?php } ?>
		</div>
	</div>
	
	
	<div class="tang-arrow">&nbsp;</div>
</div>


<script type="text/javascript">
F.use(["/browse_static/common/lib/tangram/base/base.js", "/browse_static/index/ui/setup/hotvideo/hotvideo.js"], function(T, setupHotvideo) {
	T.dom.ready(function() {
	var hotvideo = window.hotvideo = setupHotvideo('hotVideo', {
		selectEvent: 'mouseover'
		,selectDelay: 60
        ,autoPlay: true
	});	
	});

});
</script>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fis_widget(array('count'=>5), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>