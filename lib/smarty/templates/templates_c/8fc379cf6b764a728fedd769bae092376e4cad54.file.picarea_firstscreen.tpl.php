<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:28
         compiled from "/home/video/channel/template/browse_template/widget/index/picarea_firstscreen/picarea_firstscreen.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1957871515532a3adc568c49-76379185%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8fc379cf6b764a728fedd769bae092376e4cad54' => 
    array (
      0 => '/home/video/channel/template/browse_template/widget/index/picarea_firstscreen/picarea_firstscreen.tpl',
      1 => 1377251509,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1957871515532a3adc568c49-76379185',
  'function' => 
  array (
    'picarea_firstscreen' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'data' => 0,
    '($_smarty_tpl->tpl_vars[\'data\']->value[0])' => 0,
    '($_smarty_tpl->tpl_vars[\'data\']->value[1])' => 0,
    'evalData0' => 0,
    'e' => 0,
    'customClass' => 0,
    'hao123Movie' => 0,
    'movieCates' => 0,
    'cate' => 0,
    'id' => 0,
    'evalData1' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adc6e8be',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adc6e8be')) {function content_532a3adc6e8be($_smarty_tpl) {?><?php if (!is_callable('smarty_block_fis_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/block.fis_widget.php';
?><?php $_smarty_tpl->smarty->_tag_stack[] = array('fis_widget', array()); $_block_repeat=true; echo smarty_block_fis_widget(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<?php if (!is_callable('smarty_function_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/function.widget.php';
if (!is_callable('smarty_modifier_escape')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.escape.php';
if (!is_callable('smarty_modifier_f_escape_xml')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.f_escape_xml.php';
if (!is_callable('smarty_modifier_truncate_gbk')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.truncate_gbk.php';
?><?php if (!function_exists('smarty_template_function_picarea_firstscreen')) {
    function smarty_template_function_picarea_firstscreen($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['picarea_firstscreen']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>

	<?php $_smarty_tpl->tpl_vars['evalData0'] = new Smarty_variable($_smarty_tpl->tpl_vars[($_smarty_tpl->tpl_vars['data']->value[0])]->value, null, 0);?>
	<?php $_smarty_tpl->tpl_vars['evalData1'] = new Smarty_variable($_smarty_tpl->tpl_vars[($_smarty_tpl->tpl_vars['data']->value[1])]->value, null, 0);?>

	<div class="pa-first-screen">
		<div class="pa-first-screen-focus">
			<ul class="video-item-list list-two">
				
				<?php  $_smarty_tpl->tpl_vars['e'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['e']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['evalData0']->value["videos"]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['e']->iteration=0;
 $_smarty_tpl->tpl_vars['e']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['e']->key => $_smarty_tpl->tpl_vars['e']->value){
$_smarty_tpl->tpl_vars['e']->_loop = true;
 $_smarty_tpl->tpl_vars['e']->iteration++;
 $_smarty_tpl->tpl_vars['e']->index++;
?>
				
				<?php if ($_smarty_tpl->tpl_vars['e']->index<2){?>
				<?php $_smarty_tpl->tpl_vars['customClass'] = new Smarty_variable('', null, 0);?>
				
				<?php if ($_smarty_tpl->tpl_vars['e']->index==1){?>
					<?php $_smarty_tpl->tpl_vars['customClass'] = new Smarty_variable("row-last", null, 0);?>
				<?php }?>	
				
				<?php echo smarty_function_widget(array('path'=>"widget/index/videoitem/videoitem.tpl",'data'=>$_smarty_tpl->tpl_vars['e']->value,'customClass'=>$_smarty_tpl->tpl_vars['customClass']->value,'thumbType'=>"125v",'truncCount'=>14,'imgProp'=>"imgv_url",'orderNum'=>$_smarty_tpl->tpl_vars['e']->iteration,'siteList'=>false,'lazyload'=>1),$_smarty_tpl);?>

				
				<?php }?>
				<?php } ?>
			</ul>	
		
            <?php if ((($tmp = @$_smarty_tpl->tpl_vars['hao123Movie']->value)===null||$tmp==='' ? false : $tmp)){?>
                <?php $_smarty_tpl->tpl_vars['movieCates'] = new Smarty_variable(array(array('title'=>'动作','kw'=>'%B6%AF%D7%F7'),array('title'=>'恶搞','kw'=>'%B6%F1%B8%E3'),array('title'=>'动画','kw'=>'%B6%AF%BB%AD'),array('title'=>'战争','kw'=>'%D5%BD%D5%F9'),array('title'=>'恐怖','kw'=>'%BF%D6%B2%C0'),array('title'=>'剧情','kw'=>'%BE%E7%C7%E9'),array('title'=>'单亲','kw'=>'%B5%A5%C7%D7'),array('title'=>'科幻','kw'=>'%BF%C6%BB%C3'),array('title'=>'灾难','kw'=>'%D4%D6%C4%D1'),array('title'=>'伦理','kw'=>'%C2%D7%C0%ED'),array('title'=>'文艺','kw'=>'%CE%C4%D2%D5'),array('title'=>'青春','kw'=>'%C7%E0%B4%BA'),array('title'=>'冒险','kw'=>'%C3%B0%CF%D5'),array('title'=>'脱俗','kw'=>'%CD%D1%CB%D7')), null, 0);?>
                <h3>更多分类</h3>
                <ul class="pa-first-screen-categories">
                    <?php  $_smarty_tpl->tpl_vars['cate'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cate']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['movieCates']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cate']->key => $_smarty_tpl->tpl_vars['cate']->value){
$_smarty_tpl->tpl_vars['cate']->_loop = true;
?>
                         <li><a href="http://video.hao123.com/recommend/dianying/?kw=<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['cate']->value['kw'], 'none');?>
" target="_blank" static="stp=ti" title="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['cate']->value['title']);?>
"><?php echo smarty_modifier_f_escape_xml(smarty_modifier_truncate_gbk($_smarty_tpl->tpl_vars['cate']->value['title'],16));?>
</a></li>
                    <?php } ?>
                </ul>
                <?php echo smarty_function_widget(array('path'=>"widget/index/filmnews/filmnews.tpl"),$_smarty_tpl);?>

            <?php }else{ ?>
                <?php if ((($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||$tmp==='' ? '' : $tmp)=="index_show_movie"){?>
					<h3>更多大片</h3>
					<ul class="pa-first-screen-more">
						<?php  $_smarty_tpl->tpl_vars['e'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['e']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['evalData1']->value["videos"]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['e']->iteration=0;
 $_smarty_tpl->tpl_vars['e']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['e']->key => $_smarty_tpl->tpl_vars['e']->value){
$_smarty_tpl->tpl_vars['e']->_loop = true;
 $_smarty_tpl->tpl_vars['e']->iteration++;
 $_smarty_tpl->tpl_vars['e']->index++;
?>
							<?php if ($_smarty_tpl->tpl_vars['e']->index<12){?>
								<li<?php if ($_smarty_tpl->tpl_vars['e']->index%2==1){?> class="row-last"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['e']->value['url'];?>
" target="_blank" static="stp=ti&no=<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['e']->iteration);?>
" title="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['e']->value['title']);?>
"><?php echo smarty_modifier_f_escape_xml(smarty_modifier_truncate_gbk($_smarty_tpl->tpl_vars['e']->value['title'],20));?>
</a></li>
							<?php }?>
						<?php } ?>
					</ul>
					<?php }elseif((($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||$tmp==='' ? '' : $tmp)=="index_show_tv"){?>
					<?php echo smarty_function_widget(array('path'=>"widget/index/chan_hot_tv/chan_hot_tv.tpl",'data'=>$_smarty_tpl->tpl_vars['evalData1']->value["videos"]),$_smarty_tpl);?>
				
				<?php }?>             
            <?php }?>
		</div>
		<div class="pa-first-screen-list">
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
				
				<?php if ($_smarty_tpl->tpl_vars['e']->index>1&&$_smarty_tpl->tpl_vars['e']->index<8){?>
				<?php $_smarty_tpl->tpl_vars['customClass'] = new Smarty_variable('', null, 0);?>
				
				<?php if ($_smarty_tpl->tpl_vars['e']->index%3==1){?>
					<?php $_smarty_tpl->tpl_vars['customClass'] = new Smarty_variable("row-last", null, 0);?>
				<?php }?>	
				
				<?php echo smarty_function_widget(array('path'=>"widget/index/videoitem/videoitem.tpl",'data'=>$_smarty_tpl->tpl_vars['e']->value,'customClass'=>$_smarty_tpl->tpl_vars['customClass']->value,'thumbType'=>"125v",'truncCount'=>14,'imgProp'=>"imgv_url",'orderNum'=>$_smarty_tpl->tpl_vars['e']->iteration,'siteList'=>false,'lazyload'=>1),$_smarty_tpl);?>

				
				<?php }?>
				<?php } ?>
			</ul>	
		</div>
	</div><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fis_widget(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>