<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:28
         compiled from "/home/video/channel/template/browse_template/widget/common/statistics/statistics.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1150751160532a3adcba9d91-24298436%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b89bd2001c663825e48284908e54e5d162a6e67' => 
    array (
      0 => '/home/video/channel/template/browse_template/widget/common/statistics/statistics.tpl',
      1 => 1387615248,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1150751160532a3adcba9d91-24298436',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'uid' => 0,
    'refer' => 0,
    'word' => 0,
    'tn' => 0,
    'pn' => 0,
    'logParams' => 0,
    'd' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adcc58ab',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adcc58ab')) {function content_532a3adcc58ab($_smarty_tpl) {?><?php if (!is_callable('smarty_block_fis_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/block.fis_widget.php';
if (!is_callable('smarty_modifier_f_escape_js')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.f_escape_js.php';
?><?php $_smarty_tpl->smarty->_tag_stack[] = array('fis_widget', array('uid'=>'','refer'=>'','word'=>'','tn'=>'','logParams'=>array())); $_block_repeat=true; echo smarty_block_fis_widget(array('uid'=>'','refer'=>'','word'=>'','tn'=>'','logParams'=>array()), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<script type="text/javascript">
F.use(["/browse_static/common/lib/tangram/base/base.js", "/browse_static/common/ui/vs/statistics/statistics.js"], function(T) {
	T.dom.ready(function() {
	<?php if ($_smarty_tpl->tpl_vars['uid']->value){?>
		var uid = T.cookie.get('BAIDUID');
		uid = uid.substring(0, uid.indexOf(':')) + (new Date().getTime());
		V.nsclick.setParam('uid', uid);
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['refer']->value){?>V.nsclick.setParam('refer', '<?php echo urlencode($_smarty_tpl->tpl_vars['refer']->value);?>
');<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['word']->value){?>V.nsclick.setParam('wd', '<?php echo smarty_modifier_f_escape_js($_smarty_tpl->tpl_vars['word']->value);?>
');<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['tn']->value){?>V.nsclick.setParam('tn', '<?php echo smarty_modifier_f_escape_js($_smarty_tpl->tpl_vars['tn']->value);?>
');<?php }?>
	<?php if (isset($_smarty_tpl->tpl_vars['pn']->value)&&$_smarty_tpl->tpl_vars['pn']->value){?>V.nsclick.setParam('pn', '<?php echo smarty_modifier_f_escape_js($_smarty_tpl->tpl_vars['pn']->value);?>
');<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['logParams']->value){?>
		<?php  $_smarty_tpl->tpl_vars['d'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['d']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['logParams']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['d']->key => $_smarty_tpl->tpl_vars['d']->value){
$_smarty_tpl->tpl_vars['d']->_loop = true;
?>
			<?php if (isset($_smarty_tpl->tpl_vars['d']->value['name'])&&isset($_smarty_tpl->tpl_vars['d']->value['value'])){?>
				V.nsclick.setParam('<?php echo smarty_modifier_f_escape_js($_smarty_tpl->tpl_vars['d']->value['name']);?>
', '<?php if (isset($_smarty_tpl->tpl_vars['d']->value['isencode'])&&$_smarty_tpl->tpl_vars['d']->value['isencode']){?><?php echo urlencode($_smarty_tpl->tpl_vars['d']->value['value']);?>
<?php }else{ ?><?php echo smarty_modifier_f_escape_js($_smarty_tpl->tpl_vars['d']->value['value']);?>
<?php }?>');
			<?php }?>
		<?php } ?>
	<?php }?>
	});
});
</script>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fis_widget(array('uid'=>'','refer'=>'','word'=>'','tn'=>'','logParams'=>array()), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>