<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:28
         compiled from "/home/video/channel/template/browse_template/widget/index/morehot/morehot.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1142267392532a3adc1f7a92-70790444%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b5ac5b72b2b2f714ff588a4ea1415d2d9a0908ea' => 
    array (
      0 => '/home/video/channel/template/browse_template/widget/index/morehot/morehot.tpl',
      1 => 1377251509,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1142267392532a3adc1f7a92-70790444',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'count' => 0,
    'pageTn' => 0,
    'd' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adc276f5',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adc276f5')) {function content_532a3adc276f5($_smarty_tpl) {?><?php if (!is_callable('smarty_block_fis_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/block.fis_widget.php';
if (!is_callable('smarty_modifier_f_escape_xml')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.f_escape_xml.php';
if (!is_callable('smarty_modifier_truncate_gbk')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.truncate_gbk.php';
?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('fis_widget', array('count'=>12)); $_block_repeat=true; echo smarty_block_fis_widget(array('count'=>12), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<div id="more-hot" static="s=1600&tn=index&bl=morehot" monkey="morehot">
	<div id="tang-carouselA" class="tang-carousel">
		<h3>更多热门资讯
			<ul id="dotted" class="dotted-container">
				<li class="item-selected"></li>
				<li></li>
				<li></li>
			</ul>
			<a class="tang-carousel-btn tang-carousel-btn-prev" href="#" onclick="return false;" static="stp=op">left</a>
			<a class="tang-carousel-btn tang-carousel-btn-next" href="#" onclick="return false;" static="stp=op">right</a>
		</h3>
		<div class="tang-carousel-container">
			<ol class="tang-carousel-element">
			<?php  $_smarty_tpl->tpl_vars['d'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['d']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['d']->iteration=0;
 $_smarty_tpl->tpl_vars['d']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['d']->key => $_smarty_tpl->tpl_vars['d']->value){
$_smarty_tpl->tpl_vars['d']->_loop = true;
 $_smarty_tpl->tpl_vars['d']->iteration++;
 $_smarty_tpl->tpl_vars['d']->index++;
?>
				<?php if ($_smarty_tpl->tpl_vars['d']->index<$_smarty_tpl->tpl_vars['count']->value){?>
				<li class="tang-carousel-item" static="no=<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['d']->iteration);?>
">
				<dl static="s=1600&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&bl=morehot">
					<dt>
						<a href="<?php echo $_smarty_tpl->tpl_vars['d']->value['url'];?>
" target="_blank" static="stp=po">
							<img src="<?php echo $_smarty_tpl->tpl_vars['d']->value['imgh_url'];?>
"/>
							<?php if ($_smarty_tpl->tpl_vars['d']->value['is_play']==1){?><span class="playicon"></span><?php }?>
							<span class="duration"><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['d']->value['duration']);?>
</span>
						</a>
					</dt>
					<dd class="title"><img src="<?php echo $_smarty_tpl->tpl_vars['d']->value['url_site'];?>
" /><a href="<?php echo $_smarty_tpl->tpl_vars['d']->value['url'];?>
" target="_blank" static="stp=ti"><?php echo smarty_modifier_f_escape_xml(smarty_modifier_truncate_gbk($_smarty_tpl->tpl_vars['d']->value['title'],42,''));?>
</a></dd>
				</dl>
				</li>
				<?php }?>
			<?php } ?>
			</ol>
		</div>
	</div>
</div>
<script type='text/javascript'>
	F.use("/browse_static/widget/index/morehot/morehot.js");
</script>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fis_widget(array('count'=>12), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>


<?php }} ?>