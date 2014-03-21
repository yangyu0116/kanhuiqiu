<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:27
         compiled from "/home/video/channel/template/browse_template/widget/common/userbar/userbar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1337736669532a3adbd49963-60545547%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90d8dd70eddaf4a031c16522634dc32698ccfde5' => 
    array (
      0 => '/home/video/channel/template/browse_template/widget/common/userbar/userbar.tpl',
      1 => 1387615249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1337736669532a3adbd49963-60545547',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pageS' => 0,
    'pageTn' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adbd8212',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adbd8212')) {function content_532a3adbd8212($_smarty_tpl) {?><?php if (!is_callable('smarty_block_fis_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/block.fis_widget.php';
?><?php $_smarty_tpl->smarty->_tag_stack[] = array('fis_widget', array()); $_block_repeat=true; echo smarty_block_fis_widget(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<div id="userbar" static="s=<?php echo $_smarty_tpl->tpl_vars['pageS']->value;?>
&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&bl=userbar" monkey="userbar" alog-alias="userbar">
	<ul></ul>
</div>
<script type="text/javascript">
	F.use(['/browse_static/common/lib/tangram/base/base.js','/browse_static/widget/common/userbar/userbar.js','/browse_static/common/ui/vs/loginCheck/loginCheck.js'], function(T, initUserBar, loginCheck) {
		loginCheck(function(userinfo) {
			if ( userinfo && userinfo.value ) {
				T.dom.addClass(document.body, 'global-logged');
				T.sio.log('http://nsclick.baidu.com/v.gif?pid=104&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&login=true&uname=' + encodeURIComponent(userinfo.value));
			}
			initUserBar(userinfo);
		});
	});
</script>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fis_widget(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>