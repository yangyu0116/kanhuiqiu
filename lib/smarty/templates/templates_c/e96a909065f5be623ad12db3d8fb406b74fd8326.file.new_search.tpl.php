<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:27
         compiled from "/home/video/channel/template/browse_template/widget/common/new_search/new_search.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1221060741532a3adbde8e05-95537784%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e96a909065f5be623ad12db3d8fb406b74fd8326' => 
    array (
      0 => '/home/video/channel/template/browse_template/widget/common/new_search/new_search.tpl',
      1 => 1387615249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1221060741532a3adbde8e05-95537784',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'wd' => 0,
    'isui' => 0,
    'pageTn' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adbe8804',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adbe8804')) {function content_532a3adbe8804($_smarty_tpl) {?><?php if (!is_callable('smarty_block_fis_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/block.fis_widget.php';
if (!is_callable('smarty_modifier_f_escape_xml')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/modifier.f_escape_xml.php';
?><?php $_smarty_tpl->smarty->_tag_stack[] = array('fis_widget', array('wd'=>'','isBaidu'=>1,'isui'=>0)); $_block_repeat=true; echo smarty_block_fis_widget(array('wd'=>'','isBaidu'=>1,'isui'=>0), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<form action="http://v.baidu.com/v" method="get" name="f1" id="bdvSearch" class="bdv-search">
	<span class="bdv-search-inputs">
		<input type="text" maxlength="120" id="kw" name="word" value="<?php echo smarty_modifier_f_escape_xml($_smarty_tpl->tpl_vars['wd']->value);?>
" />
	</span>
	<span class="bdv-search-btns">
		<input type="submit" value="百度一下" id="bdvSearchBtn" onmousedown="this.className='bdv-search-btn-down'" onmouseout="this.className=''" />
	</span>
	<input name="ct" type="hidden" value="301989888" />
	<input name="rn" type="hidden" value="20" />
	<input name="pn" type="hidden" value="0" />
	<input name="db" type="hidden" value="0" />
	<input name="s" type="hidden" value="0" />
	<input name="fbl" type="hidden" value="800" />
	<input name="oq" type="hidden"  disabled="disabled" />
	<input name="f" type="hidden" value="3"  disabled="disabled" />
	<input name="rsp" type="hidden"  disabled="disabled" />
</form>
<script type="text/javascript" id="bdvsug_js" charset="utf-8"></script>
<script type="text/javascript">
var bdvSugConfig = {
	form: 'bdvSearch',
	input: 'kw',
	num: 6,
	delay: 200
};
<?php if ($_smarty_tpl->tpl_vars['isui']->value){?>
bdvSugConfig.classname = 'ui-suggestion';
<?php }?>
(function() {
	function loadImg(src) {
		var t = new Date().getTime(),
			img = window['V_fix_img'+t] = new Image();
		img.onload = img.onerror = img.onabort = function() {
			img.onload = img.onerror = img.onabort = null;
			try {
				delete window['V_fix_img'+t];
				img = null;
			} catch(e) {
				img = null;
			}
		}
		img.src = src+'&r='+t;
	};
	var types = {
		movie: 21,
		tv: 22,
		show: 26,
		comic: 43,
		person: 50
	};
	var match = location.search.match(/[&?]q=([^&]+)/);
	if(match){
		document.getElementById('kw').value = decodeURIComponent(match[1]);
	}
	bdvSugConfig.onsubmit = function(evt) {
		loadImg('http://nsclick.baidu.com/v.gif?pid=104&tn=sug&s=zdjs&input=' + encodeURIComponent(evt.query) + '&wd=' + encodeURIComponent(evt.title) + '&li=' + evt.index);
	};
	bdvSugConfig.onclicklink = function(evt) {
		loadImg('http://nsclick.baidu.com/v.gif?pid=104&tn=sug&s=zdjs&bl=spa&input=' + encodeURIComponent(evt.query) + '&wd=' + encodeURIComponent(evt.title) + '&id=' + evt.id + '&ty=' + types[evt.type] + '&stp=' + evt.target + '&li=' + evt.index + '&u=' + encodeURIComponent(evt.url));
	};
	F.use(['/browse_static/common/lib/tangram/base/base.js','/browse_static/widget/common/new_search/new_search.js'], function(T,searchHolder) {
		T.on('bdvSearchBtn', 'click', function(e) {
			var logUrl = 'http://nsclick.baidu.com/v.gif?pid=104&s=zdjs&wd=' + encodeURIComponent(T.dom.g('kw').value);
			T.event.preventDefault(e);
			T.event.stopPropagation(e);
			if(searchHolder.isPrekeyword()){
				logUrl += '&bl=default'
			}
			loadImg(logUrl);
			setTimeout(function() {
				T.dom.g('bdvSearch').submit();
			}, 200);
		});
		T.dom.ready(function(){
			searchHolder.init('<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
');
		})
	});
}());
document.getElementById('bdvsug_js').src = 'http://list.video.baidu.com/pc_static/open/suggestion/sug-high-min.js?v=' + Math.ceil(new Date() / 7200000);
</script>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fis_widget(array('wd'=>'','isBaidu'=>1,'isui'=>0), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>