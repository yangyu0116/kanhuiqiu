<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:28
         compiled from "/home/video/channel/template/browse_template/widget/common/footer/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1151400291532a3adcb59272-26295208%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '53726953c4c3971312aa9739b0632a90542f9c40' => 
    array (
      0 => '/home/video/channel/template/browse_template/widget/common/footer/footer.tpl',
      1 => 1387615249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1151400291532a3adcb59272-26295208',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pageS' => 0,
    'pageTn' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adcb9921',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adcb9921')) {function content_532a3adcb9921($_smarty_tpl) {?><?php if (!is_callable('smarty_block_fis_widget')) include '/home/video/northwood/kanhuiqiu_com/kanhuiqiu/lib/smarty/libs/plugins/block.fis_widget.php';
?><?php $_smarty_tpl->smarty->_tag_stack[] = array('fis_widget', array()); $_block_repeat=true; echo smarty_block_fis_widget(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<div class="footer" monkey="footer" static="s=<?php echo $_smarty_tpl->tpl_vars['pageS']->value;?>
&tn=<?php echo $_smarty_tpl->tpl_vars['pageTn']->value;?>
&bl=footer">
	<p class="video-tcip">
		<a href="http://service.baidu.com/question?prod_en=video" target="_blank">����</a>
		| <a href="http://v.baidu.com/videoop.html" target="_blank">��������Ƶ����Э��</a>
		| <a href="http://qingting.baidu.com/index?pid=4" target="_blank">�������</a>
	</p>
	<p class="footer-ad">
		<a href="#" onclick="h(this,'http://www.baidu.com/');">�Ѱٶ���Ϊ��ҳ</a> | <a
			href="http://top.baidu.com/">�������ư�</a>
		| <a href="http://home.baidu.com/">���ڰٶ�</a>
	</p>
	<p>�ٶ���Ƶ�������Դ�ڻ�������Ƶ��վ��ϵ�����ϵͳ���������ȶ��Զ����У�������ٶ��޳ɱ�������վ�����ݻ�������</p>
	<p class="copy-right">
		&copy;
		2013
		Baidu <a href="http://www.baidu.com/duty/">ʹ�ðٶ�ǰ�ض�</a>
		<span> | </span><a href="http://v.baidu.com/license.html">�����������֤0110516��</a>
	</p>
	<script>
	function h(obj, url){
		 if (document.all) {
		 obj.style.behavior = 'url(#default#homepage)';
		 obj.setHomePage(url);
		 }
		}
	F.use(['/browse_static/common/lib/tangram/base/base.js'], function(T, S) {
		T.dom.ready(function() {
			//��ʼ��videoadv���
			T.sio.callByBrowser('http://list.video.baidu.com/videoadv.js?v=' + Math.ceil(new Date() / 7200000),null,{charset:'gb2312'});
		});
	});
	</script>
	<div id="baidu_statics">
	<script type="text/javascript">
	var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
	document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F621508c7f12eb1422f1cd385b626f47e' type='text/javascript'%3E%3C/script%3E"));
	</script>
	</div>
</div>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fis_widget(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>