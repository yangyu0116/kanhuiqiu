<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:28
         compiled from "/home/video/channel/template/browse_template/widget/common/tabpicarea/tabpicarea.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2129841816532a3adc81ceb1-06432871%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a74873d6e666659c097d80a4287e049e66b16f8e' => 
    array (
      0 => '/home/video/channel/template/browse_template/widget/common/tabpicarea/tabpicarea.tpl',
      1 => 1387615249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2129841816532a3adc81ceb1-06432871',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'custom' => 0,
    'id' => 0,
    'pageS' => 0,
    'pageTn' => 0,
    'headConf' => 0,
    'tabConf' => 0,
    't' => 0,
    'monkey' => 0,
    'monkeyconfig' => 0,
    'linktype' => 0,
    'urlfield' => 0,
    'thumbType' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adc9894c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adc9894c')) {function content_532a3adc9894c($_smarty_tpl) {?><?php if (!is_callable('smarty_block_fis_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/block.fis_widget.php';
if (!is_callable('smarty_modifier_f_escape_xml')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.f_escape_xml.php';
if (!is_callable('smarty_modifier_f_escape_js')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.f_escape_js.php';
?><?php $_smarty_tpl->smarty->_tag_stack[] = array('fis_widget', array('monkey'=>'','monkeyconfig'=>'','id'=>'')); $_block_repeat=true; echo smarty_block_fis_widget(array('monkey'=>'','monkeyconfig'=>'','id'=>''), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<div class="tabpicarea tang-ui tang-tab <?php if (isset($_smarty_tpl->tpl_vars['custom']->value)){?><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['custom']->value);?>
<?php }?>" id="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['id']->value);?>
"
	tang-param="selectedIndex: 0;" static="s=<?php echo $_smarty_tpl->tpl_vars['pageS']->value;?>
&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&bl=<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['id']->value);?>
">
	<div class="hd"><div class="hd-inner">
		<h3><?php if (isset($_smarty_tpl->tpl_vars['headConf']->value['url'])&&$_smarty_tpl->tpl_vars['headConf']->value['url']){?><a href="<?php echo $_smarty_tpl->tpl_vars['headConf']->value['url'];?>
" target="_blank" static="stp=hl"><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['headConf']->value['title']);?>
&gt;&gt;</a><?php }else{ ?><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['headConf']->value['title']);?>
<?php }?></h3>
		<?php if ($_smarty_tpl->tpl_vars['headConf']->value['morelink']){?>
		<a class="anchor-more" href="<?php echo $_smarty_tpl->tpl_vars['headConf']->value['morelink'];?>
" target="_blank" static="stp=mo">¸ü¶à&gt;&gt;</a>
		<?php }?>
		<ul class="tang-title<?php if (!$_smarty_tpl->tpl_vars['headConf']->value['morelink']){?> no-more<?php }?>">
			<?php  $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['t']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tabConf']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
			<li class="tang-title-item<?php if ($_smarty_tpl->tpl_vars['t']->first){?> first tang-title-item-selected<?php }?> s-<?php echo strlen($_smarty_tpl->tpl_vars['t']->value['name']);?>
"><a class="<?php if ($_smarty_tpl->tpl_vars['t']->first){?>first<?php }?><?php if ($_smarty_tpl->tpl_vars['t']->last){?>last<?php }?>" <?php if (isset($_smarty_tpl->tpl_vars['t']->value['url'])&&$_smarty_tpl->tpl_vars['t']->value['url']){?> href="<?php echo $_smarty_tpl->tpl_vars['t']->value['url'];?>
" target="_blank" static="stp=tab"<?php }?> hidefocus="true"><span><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['t']->value['name']);?>
</span></a></li>
			<?php } ?>
		</ul>
	</div></div>
	<div class="bd tang-body"<?php if ($_smarty_tpl->tpl_vars['monkey']->value!==false){?> monkey="<?php if ($_smarty_tpl->tpl_vars['monkey']->value){?><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['monkey']->value);?>
<?php }else{ ?><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['id']->value);?>
<?php }?>"<?php }?><?php if ($_smarty_tpl->tpl_vars['monkeyconfig']->value){?> monkeyconfig="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['monkeyconfig']->value);?>
"<?php }?>>
		<?php  $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['t']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tabConf']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
		<div class="tang-body-item <?php if ($_smarty_tpl->tpl_vars['t']->first){?>tang-body-item-first tang-body-item-selected<?php }?>">
			<?php if (!$_smarty_tpl->tpl_vars['t']->first){?>
			<script type="text/tabcontent">
			<?php }?>
			<?php if (isset($_smarty_tpl->tpl_vars['t']->value['linktype'])){?>
				<?php $_smarty_tpl->tpl_vars['linktype'] = new Smarty_variable($_smarty_tpl->tpl_vars['t']->value['linktype'], null, 0);?>
			<?php }else{ ?>
				<?php $_smarty_tpl->tpl_vars['linktype'] = new Smarty_variable('', null, 0);?>
			<?php }?>
			<?php if (isset($_smarty_tpl->tpl_vars['t']->value['thumbType'])){?>
				<?php $_smarty_tpl->tpl_vars['thumbType'] = new Smarty_variable($_smarty_tpl->tpl_vars['t']->value['thumbType'], null, 0);?>
			<?php }else{ ?>
				<?php $_smarty_tpl->tpl_vars['thumbType'] = new Smarty_variable('', null, 0);?>
			<?php }?>
			<?php if (isset($_smarty_tpl->tpl_vars['t']->value['urlfield'])&&$_smarty_tpl->tpl_vars['t']->value['urlfield']){?>
				<?php $_smarty_tpl->tpl_vars['urlfield'] = new Smarty_variable($_smarty_tpl->tpl_vars['t']->value['urlfield'], null, 0);?>
			<?php }else{ ?>
				<?php $_smarty_tpl->tpl_vars['urlfield'] = new Smarty_variable("url", null, 0);?>
			<?php }?>
				<?php $tmp = "smarty_template_function_".$_smarty_tpl->tpl_vars['t']->value['tpl']; $tmp($_smarty_tpl,array('data'=>$_smarty_tpl->tpl_vars['t']->value['data'],'limit'=>$_smarty_tpl->tpl_vars['t']->value['limit'],'linktype'=>$_smarty_tpl->tpl_vars['linktype']->value,'urlfield'=>$_smarty_tpl->tpl_vars['urlfield']->value,'thumbType'=>$_smarty_tpl->tpl_vars['thumbType']->value));?>

			<?php if (!$_smarty_tpl->tpl_vars['t']->first){?>
			</script>
			<?php }?>
		</div>
		<?php } ?>

	</div>
</div>

<script type="text/javascript" charset="utf-8">
	F.use(['/browse_static/widget/common/tabpicarea/tabpicarea.js'], function (initTab) {
		initTab('<?php echo smarty_modifier_f_escape_js($_smarty_tpl->tpl_vars['id']->value);?>
');
	});
 </script>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fis_widget(array('monkey'=>'','monkeyconfig'=>'','id'=>''), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>