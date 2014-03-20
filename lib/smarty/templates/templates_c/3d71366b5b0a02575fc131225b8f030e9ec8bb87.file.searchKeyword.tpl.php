<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:27
         compiled from "/home/video/channel/template/browse_template/widget/common/searchKeyword/searchKeyword.tpl" */ ?>
<?php /*%%SmartyHeaderCode:238840367532a3adbe95720-58545411%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3d71366b5b0a02575fc131225b8f030e9ec8bb87' => 
    array (
      0 => '/home/video/channel/template/browse_template/widget/common/searchKeyword/searchKeyword.tpl',
      1 => 1387615249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '238840367532a3adbe95720-58545411',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'idBox' => 0,
    'pageS' => 0,
    'pageTn' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adbed641',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adbed641')) {function content_532a3adbed641($_smarty_tpl) {?><?php if (!is_callable('smarty_block_fis_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/block.fis_widget.php';
if (!is_callable('smarty_modifier_f_escape_xml')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.f_escape_xml.php';
?><?php $_smarty_tpl->smarty->_tag_stack[] = array('fis_widget', array('idBox'=>"top_search_Keyword",'videoApi'=>"index_search_keyword")); $_block_repeat=true; echo smarty_block_fis_widget(array('idBox'=>"top_search_Keyword",'videoApi'=>"index_search_keyword"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<div id="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['idBox']->value);?>
" static="s=<?php echo $_smarty_tpl->tpl_vars['pageS']->value;?>
&amp;tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&amp;bl=<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['idBox']->value);?>
" monkey="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['idBox']->value);?>
"></div>
<script type="text/html" id="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['idBox']->value);?>
Html">
	<<?php ?>%
		if ( typeof data === 'object' && data[0] && data[0].data && data[0].data.videos ) {
			for ( var videos = data[0].data.videos, i = 0, len = videos.length; i < len && i < 8; i++ ) {
				var item = videos[i];
	%<?php ?>>
		<a class="default_style set_<<?php ?>%=item.hot_day%<?php ?>>" target="_blank" href="<<?php ?>%=item.url%<?php ?>>"><<?php ?>%=item.title%<?php ?>></a>
	<<?php ?>%
			}
		}
	%<?php ?>>  
</script>
<script type="text/javascript">
F.use("/browse_static/widget/common/searchKeyword/searchKeyword.js");
</script>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fis_widget(array('idBox'=>"top_search_Keyword",'videoApi'=>"index_search_keyword"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>