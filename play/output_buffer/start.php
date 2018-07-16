<?php
require 'public.php';

/*
 * ob_start() 函数
 * context: output_buffering=Off
 */

$GLOBALS['salvare_record']['default'] = __DIR__.'/temp';

// ob_flags();exit;
// flags 参数
function ob_flags() {
	printf('%b <br/>', PHP_OUTPUT_HANDLER_CLEANABLE); //   10000
	printf('%b <br/>', PHP_OUTPUT_HANDLER_FLUSHABLE); //  100000
	printf('%b <br/>', PHP_OUTPUT_HANDLER_REMOVABLE); // 1000000
	printf('%b <br/>', PHP_OUTPUT_HANDLER_STDFLAGS);  // 1110000
	
	// PHP_OUTPUT_HANDLER_CLEANABLE ob_clean, ob_end_clean, and ob_get_clean
	// PHP_OUTPUT_HANDLER_FLUSHABLE ob_end_flush, ob_flush, and ob_get_flush
	// PHP_OUTPUT_HANDLER_REMOVABLE ob_end_clean, ob_end_flush, and ob_get_flush
}
 

ob_start(
	'output_callback', // 刷新 或 清空 ob 时，会调用该 回调函数 
	8, // 缓冲区大小
	PHP_OUTPUT_HANDLER_CLEANABLE | PHP_OUTPUT_HANDLER_FLUSHABLE | PHP_OUTPUT_HANDLER_REMOVABLE ); // （大概是）设置缓冲区允许的操作，`ob_clean` `ob_flush` 之类 【注：虽然看文档默认参数是null，但当我传入null时发现ob_flush用不了了】

record( ob_get_level(), 'level' ); 
echo '1234';
echo '567';
echo '8'; // ob_length=8，自动刷新一次
echo '9';
record( ob_flush(), 'ob_flush' ); // ob_length=1，手动刷新 （刷新成功时会返回true）
record( ob_flush(), 'ob_flush' ); // ob_length=0时，ob_flush依然有效
echo '123456789'; // 当一次输出大于ob_length时，也会先进入ob，再一次性全部压出
// 【注意】在脚本结束之前，也会自动调用一次 ob_flush

function output_callback($data) {
	// 	fwrite($fp, "@".$data."\r\n");
	fwrite($GLOBALS['fp'], "@".strlen($data)."\r\n");
	record( $data, strlen($data) );
	return "&lt;".strlen($data)."&gt;&nbsp;".$data."<br/>";
}

exit;
?>