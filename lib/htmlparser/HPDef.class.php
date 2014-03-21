<?php

/**
 * @brief 常量定义
 * @author Administrator
 *
 */
class HPDef {
	// 内部curl调用的超时，默认值
	const CURL_TIMEOUT_MS = 1000;
	// 内部curl调用的重试次数，0表示不重试
	const CURL_RETRY = 0;
	
	// 普通文本类型
	const HTML_TYPE_TEXT = 0;
	// 图片类型
	const HTML_TYPE_PIC = 1;
	// 视频类型
	const HTML_TYPE_VIDEO = 2;
	// 图文混排类型
	const HTML_TYPE_TEXT_PIC = 3;
}

?>