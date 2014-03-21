<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:28
         compiled from "/home/video/channel/template/browse_template/widget/index/chan_hot_tv/chan_hot_tv.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1471202666532a3adca94503-26765163%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b19ce67a893425ce1472c0dac4298fc1887cf79b' => 
    array (
      0 => '/home/video/channel/template/browse_template/widget/index/chan_hot_tv/chan_hot_tv.tpl',
      1 => 1377251509,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1471202666532a3adca94503-26765163',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'd' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adcb104c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adcb104c')) {function content_532a3adcb104c($_smarty_tpl) {?><?php if (!is_callable('smarty_block_fis_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/block.fis_widget.php';
if (!is_callable('smarty_modifier_f_escape_path')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.f_escape_path.php';
if (!is_callable('smarty_modifier_f_escape_xml')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.f_escape_xml.php';
if (!is_callable('smarty_modifier_truncate_gbk')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.truncate_gbk.php';
?><?php $_smarty_tpl->smarty->_tag_stack[] = array('fis_widget', array()); $_block_repeat=true; echo smarty_block_fis_widget(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<div class="chan-hot-show" id="chan-hot-show">
	<div class="chan-hd">
		<h3>Œ¿ ”»»≤•</h3>
	</div>
	<div class="chan-bd">
		<?php  $_smarty_tpl->tpl_vars['d'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['d']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['d']->iteration=0;
 $_smarty_tpl->tpl_vars['d']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['d']->key => $_smarty_tpl->tpl_vars['d']->value){
$_smarty_tpl->tpl_vars['d']->_loop = true;
 $_smarty_tpl->tpl_vars['d']->iteration++;
 $_smarty_tpl->tpl_vars['d']->index++;
?>
			<?php if ($_smarty_tpl->tpl_vars['d']->index<4){?>
				<div class="tv-list-item">
					<div class="left-col">
						<img src="http://list.video.baidu.com/logo/tv/<?php echo smarty_modifier_f_escape_path($_smarty_tpl->tpl_vars['d']->value['sites']);?>
.gif" />
						<span class="tv-site"><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['d']->value['s_intro']);?>
</span>
					</div>
					<div class="right-col">
						<a href="http://video.baidu.com/tv/<?php echo smarty_modifier_f_escape_path($_smarty_tpl->tpl_vars['d']->value['id']);?>
.htm?frp=browse" target="_blank" title="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['d']->value['title']);?>
" static="stp=ti&no=<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['d']->iteration);?>
"><?php echo smarty_modifier_f_escape_xml(smarty_modifier_truncate_gbk($_smarty_tpl->tpl_vars['d']->value['title'],22));?>
</a>
					</div>
				</div>
			<?php }?>
		<?php } ?>		
	</div>
</div>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fis_widget(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>


<?php }} ?>