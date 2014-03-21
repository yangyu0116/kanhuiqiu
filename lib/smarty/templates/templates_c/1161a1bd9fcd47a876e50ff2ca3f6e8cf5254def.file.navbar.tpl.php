<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:27
         compiled from "/home/video/channel/template/browse_template/widget/common/navbar/navbar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1180270561532a3adbf21964-30175287%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1161a1bd9fcd47a876e50ff2ca3f6e8cf5254def' => 
    array (
      0 => '/home/video/channel/template/browse_template/widget/common/navbar/navbar.tpl',
      1 => 1387615249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1180270561532a3adbf21964-30175287',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pageS' => 0,
    'pageTn' => 0,
    'current' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adc0c56f',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adc0c56f')) {function content_532a3adc0c56f($_smarty_tpl) {?><?php if (!is_callable('smarty_block_fis_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/block.fis_widget.php';
?><?php $_smarty_tpl->smarty->_tag_stack[] = array('fis_widget', array('current'=>"index")); $_block_repeat=true; echo smarty_block_fis_widget(array('current'=>"index"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<div class="nav" static="s=<?php echo $_smarty_tpl->tpl_vars['pageS']->value;?>
&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&bl=nav" monkey="nav">
	<div class="nav_main"> 
		<ul id="navMainMenu">
			<li class="first"><a href="http://v.baidu.com/"<?php if ($_smarty_tpl->tpl_vars['current']->value=='index'){?> class="current"<?php }?>><span>首页</span></a></li>
			<li><a href="http://v.baidu.com/movie/index/"<?php if ($_smarty_tpl->tpl_vars['current']->value=='movie'){?> class="current"<?php }?>><span>电影</span></a></li>
			<li><a href="http://v.baidu.com/tv/index/"<?php if ($_smarty_tpl->tpl_vars['current']->value=='tvplay'){?> class="current"<?php }?>><span>电视剧</span></a></li>
			<li><a href="http://v.baidu.com/show/index/"<?php if ($_smarty_tpl->tpl_vars['current']->value=='tamasha'){?> class="current"<?php }?>><span>综艺</span></a></li>
			<li><a href="http://v.baidu.com/comic/index/"<?php if ($_smarty_tpl->tpl_vars['current']->value=='cartoon'){?> class="current"<?php }?>><span>动漫</span></a></li>
			<li class="nav_item_live"><a href="http://v.baidu.com/live/"<?php if ($_smarty_tpl->tpl_vars['current']->value=='live'){?> class="current"<?php }?>><span>直播</span></a></li>
			<li><a href="http://v.baidu.com/infoindex/"<?php if ($_smarty_tpl->tpl_vars['current']->value=='info'){?> class="current"<?php }?>><span>新闻</span></a></li>
			<li><a href="http://v.baidu.com/entindex/"<?php if ($_smarty_tpl->tpl_vars['current']->value=='ent'){?> class="current"<?php }?>><span>娱乐</span></a></li>
			<li><a href="http://v.baidu.com/sportindex/"<?php if ($_smarty_tpl->tpl_vars['current']->value=='sport'){?> class="current"<?php }?>><span>体育</span></a></li>
			<li><a href="http://v.baidu.com/gameindex/"<?php if ($_smarty_tpl->tpl_vars['current']->value=='game'){?> class="current"<?php }?>><span>游戏</span></a></li>
			<li><a href="http://v.baidu.com/square/"<?php if ($_smarty_tpl->tpl_vars['current']->value=='square'){?> class="current"<?php }?>><span>短视频</span></a></li>
			<li class="nav_item_guess"><a href="http://v.baidu.com/jwks/?page=guess" <?php if ($_smarty_tpl->tpl_vars['current']->value=='jwks'){?> class="current"<?php }?>><span>今晚看啥</span></a></li>
			<li class="show-for-ipad"><a href="http://itunes.apple.com/cn/app/bai-du-shi-pinhd/id573885698?mt=8" target="_blank"><span>IPAD客户端</span></a></li>
		</ul>
	</div>
	<div class="nav_sub"> 
		<ul id="navSubMenu">
			<li><a href="http://video.baidu.com/gossip/index.html"><span>八卦</span></a></li>	
			<li><a href="http://v.baidu.com/musicindex/"<?php if ($_smarty_tpl->tpl_vars['current']->value=='music'){?> class="current"<?php }?>><span>音乐</span></a></li>
			<li><a href="http://v.baidu.com/amuseindex/"<?php if ($_smarty_tpl->tpl_vars['current']->value=='fun'){?> class="current"<?php }?>><span>搞笑</span></a></li>
			<li><a href="http://v.baidu.com/top/"><span>排行榜</span></a></li>
		</ul>
	</div>
</div>
<script type="text/html" id="htmlNavMainMenu">
	<<?php ?>%
		for ( var i = 0, len = data.length; i < len; i++ ) { var item = data[i];
			if ( item.url && item.title ) {
	%<?php ?>>
		<li>
			<a href="<<?php ?>%=item.url%<?php ?>>"<<?php ?>% if (item.isopen) { %<?php ?>> target="_blank"<<?php ?>% } %<?php ?>><<?php ?>% if (item.iscurrent) { %<?php ?>> class="current"<<?php ?>% } %<?php ?>> style="position:relative;">
				<span<<?php ?>% if (item.color) { %<?php ?>> style="color:<<?php ?>%=item.color%<?php ?>>"<<?php ?>% } %<?php ?>>><<?php ?>%=item.title%<?php ?>></span>
				<<?php ?>% if ( item.isnew ) { %<?php ?>>
				<img src="http://list.video.baidu.com/pc_static/icons/new.gif" style="position:absolute;top:-2px;right:-1px;" />
				<<?php ?>% } %<?php ?>>
			</a>
		</li>
	<<?php ?>%
			}
		}
	%<?php ?>>
</script>
<script type="text/html" id="htmlNavSubMenu">
	<<?php ?>%
		for ( var i = 0, len = data.length; i < len; i++ ) { var item = data[i];
			if ( item.url && item.title ) {
	%<?php ?>>
		<li style="position:relative;">
			<a href="<<?php ?>%=item.url%<?php ?>>" target="_blank">
				<span<<?php ?>% if (item.color) { %<?php ?>> style="color:<<?php ?>%=item.color%<?php ?>>"<<?php ?>% } %<?php ?>>><<?php ?>% if (item.isbold) { %<?php ?>><b><<?php ?>%=item.title%<?php ?>></b><<?php ?>% } else { %<?php ?>><<?php ?>%=item.title%<?php ?>><<?php ?>% } %<?php ?>></span>
			</a>
			<<?php ?>% if ( item.isnew ) { %<?php ?>>
			<img src="http://list.video.baidu.com/pc_static/icons/new.gif" style="position:absolute;top:-2px;right:-1px;">
			<<?php ?>% } %<?php ?>>
		</li>
	<<?php ?>%
			}
		}
	%<?php ?>>
</script>
<script type="text/javascript">
F.use('/browse_static/widget/common/navbar/navbar.js', function() {});
if (navigator.userAgent.match(/LBBROWSER/)) {
	var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
	document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F2f0471a26bf07152b319f13212260f49' type='text/javascript'%3E%3C/script%3E"));	
}
</script>
<?php if ($_smarty_tpl->tpl_vars['pageTn']->value=="jwkssave_list"||$_smarty_tpl->tpl_vars['pageTn']->value=="jwksguess"||$_smarty_tpl->tpl_vars['pageTn']->value=="kanShort"){?>
<?php }else{ ?>
<div videoadv="page=common&amp;el=common_top_01" monkey="common_top_01"></div>
<?php }?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fis_widget(array('current'=>"index"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>