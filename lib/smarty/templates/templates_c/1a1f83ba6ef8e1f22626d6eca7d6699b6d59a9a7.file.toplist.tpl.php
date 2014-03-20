<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:28
         compiled from "/home/video/channel/template/browse_template/widget/common/toplist/toplist.tpl" */ ?>
<?php /*%%SmartyHeaderCode:121812499532a3adc2b6ce7-00768328%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1a1f83ba6ef8e1f22626d6eca7d6699b6d59a9a7' => 
    array (
      0 => '/home/video/channel/template/browse_template/widget/common/toplist/toplist.tpl',
      1 => 1387615249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '121812499532a3adc2b6ce7-00768328',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id' => 0,
    'monkey' => 0,
    'monkeyconfig' => 0,
    'data' => 0,
    'count' => 0,
    'urlfield' => 0,
    'd' => 0,
    'linktype' => 0,
    'isHao123' => 0,
    'dir' => 0,
    'pageS' => 0,
    'pageTn' => 0,
    'curl' => 0,
    'hao123' => 0,
    'isPraise' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adc440e0',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adc440e0')) {function content_532a3adc440e0($_smarty_tpl) {?><?php if (!is_callable('smarty_block_fis_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/block.fis_widget.php';
if (!is_callable('smarty_modifier_f_escape_xml')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.f_escape_xml.php';
if (!is_callable('smarty_modifier_truncate_gbk')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.truncate_gbk.php';
?><?php $_smarty_tpl->smarty->_tag_stack[] = array('fis_widget', array('count'=>10,'isPraise'=>false,'urlfield'=>"url",'monkey'=>'','monkeyconfig'=>'','hao123'=>0)); $_block_repeat=true; echo smarty_block_fis_widget(array('count'=>10,'isPraise'=>false,'urlfield'=>"url",'monkey'=>'','monkeyconfig'=>'','hao123'=>0), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<ol class="top-list" id="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['id']->value);?>
"<?php if ($_smarty_tpl->tpl_vars['monkey']->value!==false){?> monkey="<?php if ($_smarty_tpl->tpl_vars['monkey']->value){?><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['monkey']->value);?>
<?php }else{ ?><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['id']->value);?>
<?php }?>"<?php }?><?php if ($_smarty_tpl->tpl_vars['monkeyconfig']->value){?> monkeyconfig="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['monkeyconfig']->value);?>
"<?php }?>>
	<?php  $_smarty_tpl->tpl_vars['d'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['d']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['d']->iteration=0;
 $_smarty_tpl->tpl_vars['d']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['d']->key => $_smarty_tpl->tpl_vars['d']->value){
$_smarty_tpl->tpl_vars['d']->_loop = true;
 $_smarty_tpl->tpl_vars['d']->iteration++;
 $_smarty_tpl->tpl_vars['d']->index++;
 $_smarty_tpl->tpl_vars['d']->first = $_smarty_tpl->tpl_vars['d']->index === 0;
?>
		<?php if ($_smarty_tpl->tpl_vars['d']->index<$_smarty_tpl->tpl_vars['count']->value){?>
			<?php $_smarty_tpl->tpl_vars['curl'] = new Smarty_variable(($_smarty_tpl->tpl_vars['d']->value[$_smarty_tpl->tpl_vars['urlfield']->value]), null, 0);?>
			<?php if ($_smarty_tpl->tpl_vars['linktype']->value==1&&isset($_smarty_tpl->tpl_vars['d']->value['stream_type'])&&isset($_smarty_tpl->tpl_vars['d']->value['id'])&&$_smarty_tpl->tpl_vars['d']->value['id']){?>
                <?php if ((($tmp = @$_smarty_tpl->tpl_vars['isHao123']->value)===null||$tmp==='' ? false : $tmp)){?>
                    <?php $_smarty_tpl->tpl_vars['dir'] = new Smarty_variable(array('dianying','dianshi','zongyi','dongman'), null, 0);?>
                    <?php $_smarty_tpl->tpl_vars['curl'] = new Smarty_variable("/".($_smarty_tpl->tpl_vars['dir']->value[$_smarty_tpl->tpl_vars['d']->value['stream_type']-1])."/".($_smarty_tpl->tpl_vars['d']->value['id']).".htm", null, 0);?>
                <?php }else{ ?>
                    <?php $_smarty_tpl->tpl_vars['dir'] = new Smarty_variable(array('movie_intro','tv_intro','show_intro','comic_intro'), null, 0);?>
                    <?php $_smarty_tpl->tpl_vars['curl'] = new Smarty_variable("http://v.baidu.com/".($_smarty_tpl->tpl_vars['dir']->value[$_smarty_tpl->tpl_vars['d']->value['stream_type']-1])."/?id=".($_smarty_tpl->tpl_vars['d']->value['id'])."&page=1&frp=browse", null, 0);?>
                <?php }?>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['d']->first){?>
			<li class="poster" static="s=<?php echo $_smarty_tpl->tpl_vars['pageS']->value;?>
&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&bl=<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['id']->value);?>
&no=<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['d']->iteration);?>
&to=search">
				<dl>
					<dt>
						<a href="<?php echo $_smarty_tpl->tpl_vars['curl']->value;?>
" target="_blank" static="stp=po">
							<img src="<?php if ($_smarty_tpl->tpl_vars['hao123']->value==1){?><?php echo $_smarty_tpl->tpl_vars['d']->value['imgv_url'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['d']->value['imgh_url'];?>
<?php }?>" />
							<span class="poster-no"></span>
						</a>
					</dt>
					<dd class="poster-title">
						<a href="<?php echo $_smarty_tpl->tpl_vars['curl']->value;?>
" target="_blank" title="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['d']->value['title']);?>
" static="stp=ti"><?php echo smarty_modifier_f_escape_xml(smarty_modifier_truncate_gbk($_smarty_tpl->tpl_vars['d']->value['title'],17));?>
</a>
						<span class="trend<?php if ($_smarty_tpl->tpl_vars['d']->value['status_day']==0){?> hold<?php }elseif($_smarty_tpl->tpl_vars['d']->value['status_day']==1){?> rise<?php }elseif($_smarty_tpl->tpl_vars['d']->value['status_day']==2){?> down<?php }?>"></span>
					</dd>
					<dd class="poster-brief"><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['d']->value['s_intro']);?>
</dd>
					<dd class="<?php if ($_smarty_tpl->tpl_vars['isPraise']->value){?>poster-praise<?php }else{ ?>poster-info<?php }?>"><?php if ($_smarty_tpl->tpl_vars['isPraise']->value){?><?php echo sprintf("%.1f",($_smarty_tpl->tpl_vars['d']->value['rating']/10));?>
&nbsp;分<?php }else{ ?><?php echo sprintf("%.1f",($_smarty_tpl->tpl_vars['d']->value['hot_day']/10000));?>
&nbsp;万<?php }?></dd>
				</dl>
			</li>
			<?php }else{ ?>
			<li class="list" static="s=<?php echo $_smarty_tpl->tpl_vars['pageS']->value;?>
&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&bl=<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['id']->value);?>
&stp=ti&no=<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['d']->iteration);?>
&to=search">
				<a href="<?php echo $_smarty_tpl->tpl_vars['curl']->value;?>
" target="_blank" title="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['d']->value['title']);?>
">
					<span class="list-no no<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['d']->iteration);?>
"><?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['d']->iteration);?>
</span>
					<span class="list-title"><?php echo smarty_modifier_f_escape_xml(smarty_modifier_truncate_gbk($_smarty_tpl->tpl_vars['d']->value['title'],22));?>
</span>
					<span class="list-info"><?php if ($_smarty_tpl->tpl_vars['isPraise']->value){?><?php echo sprintf("%.1f",($_smarty_tpl->tpl_vars['d']->value['rating']/10));?>
&nbsp;分<?php }else{ ?><?php echo sprintf("%.1f",($_smarty_tpl->tpl_vars['d']->value['hot_day']/10000));?>
&nbsp;万<?php }?></span>
					<span class="trend<?php if ($_smarty_tpl->tpl_vars['d']->value['status_day']==0){?> hold<?php }elseif($_smarty_tpl->tpl_vars['d']->value['status_day']==1){?> rise<?php }elseif($_smarty_tpl->tpl_vars['d']->value['status_day']==2){?> down<?php }?>"></span>
				</a>
			</li>
			<?php }?>
		<?php }?>
	<?php } ?>
</ol>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fis_widget(array('count'=>10,'isPraise'=>false,'urlfield'=>"url",'monkey'=>'','monkeyconfig'=>'','hao123'=>0), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>