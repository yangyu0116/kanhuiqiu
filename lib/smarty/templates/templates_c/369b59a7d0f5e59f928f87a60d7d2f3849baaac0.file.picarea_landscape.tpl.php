<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:28
         compiled from "/home/video/channel/template/browse_template/widget/index/picarea_landscape/picarea_landscape.tpl" */ ?>
<?php /*%%SmartyHeaderCode:448233373532a3adc7792b8-98115197%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '369b59a7d0f5e59f928f87a60d7d2f3849baaac0' => 
    array (
      0 => '/home/video/channel/template/browse_template/widget/index/picarea_landscape/picarea_landscape.tpl',
      1 => 1377251509,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '448233373532a3adc7792b8-98115197',
  'function' => 
  array (
    'picarea_landscape' => 
    array (
      'parameter' => 
      array (
        'lazyload' => 0,
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'limit' => 0,
    'data' => 0,
    '($_smarty_tpl->tpl_vars[\'data\']->value[0])' => 0,
    'evalData0' => 0,
    'e' => 0,
    'customClass' => 0,
    'lazyload' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adc7e914',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adc7e914')) {function content_532a3adc7e914($_smarty_tpl) {?><?php if (!is_callable('smarty_block_fis_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/block.fis_widget.php';
?><?php $_smarty_tpl->smarty->_tag_stack[] = array('fis_widget', array()); $_block_repeat=true; echo smarty_block_fis_widget(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<?php if (!is_callable('smarty_function_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/function.widget.php';
?><?php if (!function_exists('smarty_template_function_picarea_landscape')) {
    function smarty_template_function_picarea_landscape($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['picarea_landscape']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>

	<?php if (!$_smarty_tpl->tpl_vars['limit']->value){?>
		<?php $_smarty_tpl->tpl_vars['limit'] = new Smarty_variable(12, null, 0);?>
	<?php }?>
	
	<?php $_smarty_tpl->tpl_vars['evalData0'] = new Smarty_variable($_smarty_tpl->tpl_vars[($_smarty_tpl->tpl_vars['data']->value[0])]->value, null, 0);?>

	<div class="pa-landscape">
		<div class="pa-landscape-list">
			<ul class="video-item-list">
				<?php  $_smarty_tpl->tpl_vars['e'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['e']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['evalData0']->value["videos"]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['e']->iteration=0;
 $_smarty_tpl->tpl_vars['e']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['e']->key => $_smarty_tpl->tpl_vars['e']->value){
$_smarty_tpl->tpl_vars['e']->_loop = true;
 $_smarty_tpl->tpl_vars['e']->iteration++;
 $_smarty_tpl->tpl_vars['e']->index++;
?>
				
				<?php if ($_smarty_tpl->tpl_vars['e']->index<$_smarty_tpl->tpl_vars['limit']->value){?>
				<?php $_smarty_tpl->tpl_vars['customClass'] = new Smarty_variable('', null, 0);?>
				
				<?php if ($_smarty_tpl->tpl_vars['e']->index%4==3){?>
					<?php $_smarty_tpl->tpl_vars['customClass'] = new Smarty_variable("row-last", null, 0);?>
				<?php }?>	
				
				<?php echo smarty_function_widget(array('path'=>"widget/index/videoitem/videoitem.tpl",'data'=>$_smarty_tpl->tpl_vars['e']->value,'customClass'=>$_smarty_tpl->tpl_vars['customClass']->value,'thumbType'=>"165h",'siteList'=>false,'showDuration'=>true,'titleOnly'=>true,'showLogo'=>true,'truncCount'=>46,'orderNum'=>$_smarty_tpl->tpl_vars['e']->iteration,'lazyload'=>$_smarty_tpl->tpl_vars['lazyload']->value),$_smarty_tpl);?>

				<?php }?>
				<?php } ?>
			</ul>	
		</div>
	</div><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fis_widget(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>