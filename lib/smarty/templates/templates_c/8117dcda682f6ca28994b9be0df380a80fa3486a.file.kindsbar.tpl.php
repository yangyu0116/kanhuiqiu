<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:28
         compiled from "/home/video/channel/template/browse_template/widget/index/kindsbar/kindsbar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1590837568532a3adc472a62-22768816%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8117dcda682f6ca28994b9be0df380a80fa3486a' => 
    array (
      0 => '/home/video/channel/template/browse_template/widget/index/kindsbar/kindsbar.tpl',
      1 => 1377251509,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1590837568532a3adc472a62-22768816',
  'function' => 
  array (
    'kindsfuncs' => 
    array (
      'parameter' => 
      array (
        'dataindex' => 0,
        'urlfield' => 'url',
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'dataindex' => 0,
    'data' => 0,
    '($_smarty_tpl->tpl_vars[\'data\']->value[$_smarty_tpl->tpl_vars[\'dataindex\']->value])' => 0,
    'evalData' => 0,
    'videos' => 0,
    'urlfield' => 0,
    'e' => 0,
    'id' => 0,
    'pageTn' => 0,
    'monkey' => 0,
    'monkeyconfig' => 0,
    'conf' => 0,
    't' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adc54a50',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adc54a50')) {function content_532a3adc54a50($_smarty_tpl) {?><?php if (!is_callable('smarty_block_fis_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/block.fis_widget.php';
if (!is_callable('smarty_modifier_f_escape_xml')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.f_escape_xml.php';
?><?php $_smarty_tpl->smarty->_tag_stack[] = array('fis_widget', array('monkey'=>'','monkeyconfig'=>'','urlfield'=>"url")); $_block_repeat=true; echo smarty_block_fis_widget(array('monkey'=>'','monkeyconfig'=>'','urlfield'=>"url"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<?php if (!is_callable('smarty_modifier_escape')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.escape.php';
if (!is_callable('smarty_modifier_f_escape_xml')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.f_escape_xml.php';
?><?php if (!function_exists('smarty_template_function_kindsfuncs')) {
    function smarty_template_function_kindsfuncs($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['kindsfuncs']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
	<?php $_smarty_tpl->tpl_vars['evalData'] = new Smarty_variable($_smarty_tpl->tpl_vars[($_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['dataindex']->value])]->value, null, 0);?>
	<?php $_smarty_tpl->tpl_vars['str'] = new Smarty_variable('', null, 0);?>
	<?php $_smarty_tpl->tpl_vars['videos'] = new Smarty_variable(array_slice($_smarty_tpl->tpl_vars['evalData']->value["videos"],0,10), null, 0);?>
	<?php  $_smarty_tpl->tpl_vars['e'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['e']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['videos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['e']->key => $_smarty_tpl->tpl_vars['e']->value){
$_smarty_tpl->tpl_vars['e']->_loop = true;
?>
		<a href="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['e']->value[$_smarty_tpl->tpl_vars['urlfield']->value], 'none');?>
" target="_blank" class="w<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['e']->value['hot_day']);?>
" static="stp=ti&id=<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['id']->value);?>
">
			<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['e']->value['title']);?>

		</a>
	<?php } ?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


<div id="kinds-bar" static="s=1600&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&bl=kindsbar"<?php if ($_smarty_tpl->tpl_vars['monkey']->value){?> monkey="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['monkey']->value);?>
"<?php }?><?php if ($_smarty_tpl->tpl_vars['monkeyconfig']->value){?> monkeyconfig="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['monkeyconfig']->value);?>
"<?php }?>>
	<div id="tang-carouselB" class="tang-carousel">
		<div class="tang-carousel-container">
			<ol class="tang-carousel-element">
			<?php  $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['t']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['conf']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['t']->key => $_smarty_tpl->tpl_vars['t']->value){
$_smarty_tpl->tpl_vars['t']->_loop = true;
?>
				<li class="tang-carousel-item" id="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['t']->value['tpl']);?>
">
					<dl>
						<dt class="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['t']->value['tpl']);?>
">
							<span class="s-title"><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['t']->value['name']);?>
</span>
							<a href="<?php echo $_smarty_tpl->tpl_vars['t']->value['url'];?>
" target="_blank" static="stp=hl&id=<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['t']->value['tpl']);?>
" class="link-more">¸ü¶à&gt;</a>
						</dt>
						<dd class="kinds-planA">
							<?php ob_start();?><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['t']->value['tpl']);?>
<?php $_tmp1=ob_get_clean();?><?php smarty_template_function_kindsfuncs($_smarty_tpl,array('urlfield'=>$_smarty_tpl->tpl_vars['urlfield']->value,'data'=>$_smarty_tpl->tpl_vars['t']->value['data'],'id'=>$_tmp1));?>

						</dd>
						<?php if ($_smarty_tpl->tpl_vars['t']->value['tpl']=='kinds-movie'||$_smarty_tpl->tpl_vars['t']->value['tpl']=='kinds-tv'){?>
							<dd class="kinds-planB">
								<?php ob_start();?><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['t']->value['tpl']);?>
<?php $_tmp2=ob_get_clean();?><?php smarty_template_function_kindsfuncs($_smarty_tpl,array('urlfield'=>$_smarty_tpl->tpl_vars['urlfield']->value,'data'=>$_smarty_tpl->tpl_vars['t']->value['data'],'dataindex'=>1,'id'=>$_tmp2));?>

							</dd>
						<?php }?>
					</dl>
				</li>
			<?php } ?>
			</ol>
		</div>
	</div>
</div>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fis_widget(array('monkey'=>'','monkeyconfig'=>'','urlfield'=>"url"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>