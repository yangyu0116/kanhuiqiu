<?php /* Smarty version Smarty-3.1.3, created on 2014-03-20 08:48:27
         compiled from "/home/video/channel/template/browse_template/widget/common/bdv_record/bdv_record.tpl" */ ?>
<?php /*%%SmartyHeaderCode:446002529532a3adbeea6f6-98227098%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0dd4a274931a6b2ea0210b2338e1549c211e8baa' => 
    array (
      0 => '/home/video/channel/template/browse_template/widget/common/bdv_record/bdv_record.tpl',
      1 => 1387615249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '446002529532a3adbeea6f6-98227098',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.3',
  'unifunc' => 'content_532a3adbf1548',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532a3adbf1548')) {function content_532a3adbf1548($_smarty_tpl) {?><div id="bdvRecord" class="bdv-record">
	<a href="javascript:void(0)" class="bdv-record-toggle" data-event="mouseover" hidefocus="true">¹Û¿´¼ÇÂ¼<i></i></a>
	<span class="bdv-record-num" style="display:none"></span>
	<div class="bdv-record-main"></div>
</div>
<script id="bdvrecord_js" charset="utf-8"></script>
<script type="text/javascript">
	var bdvRecordConfig = {
		proxy: location.protocol + '//' + location.host + '/browse_static/common/html/proxy_blank.html'
	};
	document.getElementById('bdvrecord_js').src = 'http://list.video.baidu.com/pc_static/open/record/bdv-record-min.js?v=' + Math.ceil(new Date() / 7200000);
</script>
<?php }} ?>