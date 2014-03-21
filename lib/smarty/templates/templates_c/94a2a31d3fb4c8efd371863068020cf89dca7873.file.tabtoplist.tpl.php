<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:28
         compiled from "/home/video/channel/template/browse_template/widget/common/tabtoplist/tabtoplist.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1860407673532a3adc9a4437-93051546%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '94a2a31d3fb4c8efd371863068020cf89dca7873' => 
    array (
      0 => '/home/video/channel/template/browse_template/widget/common/tabtoplist/tabtoplist.tpl',
      1 => 1387615248,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1860407673532a3adc9a4437-93051546',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'custom' => 0,
    'id' => 0,
    'conf' => 0,
    't' => 0,
    'monkey' => 0,
    'monkeyconfig' => 0,
    'hao123' => 0,
    '(smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars[\'t\']->value[\'data\']))' => 0,
    'count' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adca60ca',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adca60ca')) {function content_532a3adca60ca($_smarty_tpl) {?><?php if (!is_callable('smarty_block_fis_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/block.fis_widget.php';
if (!is_callable('smarty_modifier_f_escape_xml')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.f_escape_xml.php';
if (!is_callable('smarty_function_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/function.widget.php';
if (!is_callable('smarty_modifier_f_escape_js')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.f_escape_js.php';
?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('fis_widget', array('monkey'=>'','monkeyconfig'=>'','hao123'=>0)); $_block_repeat=true; echo smarty_block_fis_widget(array('monkey'=>'','monkeyconfig'=>'','hao123'=>0), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

	<div class="mod tab tang-ui tang-tab tabtoplist <?php if (isset($_smarty_tpl->tpl_vars['custom']->value)){?><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['custom']->value);?>
<?php }?>" id="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['id']->value);?>
" tang-param="selectedIndex: 0;">
		<div class="tabtoplist-hd">
			<ul class="tang-title">
				<?php  $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['t']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['conf']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['t']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['t']->iteration=0;
 $_smarty_tpl->tpl_vars['t']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['t']->key => $_smarty_tpl->tpl_vars['t']->value){
$_smarty_tpl->tpl_vars['t']->_loop = true;
 $_smarty_tpl->tpl_vars['t']->iteration++;
 $_smarty_tpl->tpl_vars['t']->index++;
 $_smarty_tpl->tpl_vars['t']->first = $_smarty_tpl->tpl_vars['t']->index === 0;
 $_smarty_tpl->tpl_vars['t']->last = $_smarty_tpl->tpl_vars['t']->iteration === $_smarty_tpl->tpl_vars['t']->total;
?>
				<li class="tang-title-item<?php if ($_smarty_tpl->tpl_vars['t']->first){?> tang-title-item-selected first<?php }?>">
					<a class="<?php if ($_smarty_tpl->tpl_vars['t']->first){?>first<?php }?><?php if ($_smarty_tpl->tpl_vars['t']->last){?>last<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['t']->value['url'];?>
" hidefocus="true" target="_blank" static="stp=tab"><span><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['t']->value['name']);?>
</span></a>
				</li>
				<?php } ?>
			</ul>
		</div>
		<div class="bd tang-body"<?php if ($_smarty_tpl->tpl_vars['monkey']->value!==false){?> monkey="<?php if ($_smarty_tpl->tpl_vars['monkey']->value){?><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['monkey']->value);?>
<?php }else{ ?><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['id']->value);?>
<?php }?>"<?php }?><?php if ($_smarty_tpl->tpl_vars['monkeyconfig']->value){?> monkeyconfig="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['monkeyconfig']->value);?>
"<?php }?>>
			<?php  $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['t']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['conf']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['t']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['t']->iteration=0;
 $_smarty_tpl->tpl_vars['t']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['t']->key => $_smarty_tpl->tpl_vars['t']->value){
$_smarty_tpl->tpl_vars['t']->_loop = true;
 $_smarty_tpl->tpl_vars['t']->iteration++;
 $_smarty_tpl->tpl_vars['t']->index++;
 $_smarty_tpl->tpl_vars['t']->first = $_smarty_tpl->tpl_vars['t']->index === 0;
 $_smarty_tpl->tpl_vars['t']->last = $_smarty_tpl->tpl_vars['t']->iteration === $_smarty_tpl->tpl_vars['t']->total;
?>
			<div class="tang-body-item<?php if ($_smarty_tpl->tpl_vars['t']->first){?> tang-body-item-selected<?php }?>">
				<?php ob_start();?><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['id']->value);?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['t']->index);?>
<?php $_tmp2=ob_get_clean();?><?php ob_start();?><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['count']->value);?>
<?php $_tmp3=ob_get_clean();?><?php echo smarty_function_widget(array('path'=>"widget/common/toplist/toplist.tpl",'hao123'=>$_smarty_tpl->tpl_vars['hao123']->value,'data'=>$_smarty_tpl->tpl_vars[(smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['t']->value['data']))]->value['videos'],'id'=>$_tmp1."_list".$_tmp2,'count'=>$_tmp3,'linktype'=>$_smarty_tpl->tpl_vars['t']->value['linktype'],'monkey'=>false),$_smarty_tpl);?>

			</div>
			<?php } ?>
		</div>
	</div>
	
	<script type="text/javascript" charset="utf-8">
	F.use("/browse_static/widget/common/tabtoplist/tabtoplist.js", function(initTab) {
		initTab("<?php echo smarty_modifier_f_escape_js($_smarty_tpl->tpl_vars['id']->value);?>
");
	});
	
	</script>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fis_widget(array('monkey'=>'','monkeyconfig'=>'','hao123'=>0), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>