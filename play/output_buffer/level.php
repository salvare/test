<?php
require 'public.php';

$GLOBALS['salvare_record']['default'] = __DIR__.'/temp'; // 用于 @ function.php -> record 

// base_level();
// ob的起始level
function base_level() {
// 	ini_set('output_buffering', 'Off'); // 动态修改配置无效，原因不详
	echo 'lv.'.ob_get_level(); 
	// 0: 当 `output_buffering=Off`; 1: 当 `output_buffering=On/Integer`
	// ↑ 可以假设：php.ini所做的配置只针对 ob.lv.1
}


// level_0();
// ob.lv.0 的含义
function level_0() {
	// context: output_buffering=Off
	if ( !ini_get('output_buffering') ) {
		record( 'lv'.ob_get_level(), 'case1' );
		echo '1<br/>'; // TAG_1
		record( ob_get_contents(), 'case1' ); // 没有捕捉到内容
		flush();
		sleep(1);
		echo '2<br/>';
		flush();
		// echo的输出 没有进入ob，直接发往了apache，不需要ob_flush
		// 同样地有这么个现象，`TAG_1`处必须 >=4Bytes 才能成功，这里不研究这个问题
	}
	
	// context: output_buffering=On
	if ( ini_get('output_buffering') ) {
		ob_end_clean();
		record( 'lv'.ob_get_level(), 'case2' );
		echo 'a<br/>'; // TAG_1
		record( ob_get_contents(), 'case2' );
		flush();
		sleep(1);
		echo 'b<br/>';
		flush();
		// 同上
	}
	
	// 结论： ob.lv.0 就是没有 输出缓冲区
}


// nest();
// ob的基础嵌套结构
function nest() {
	// context: output_buffering=On
	record( 'lv'.ob_get_level(), 'a' ); // lv1
	ob_start();
	record( 'lv'.ob_get_level(), 'b' ); // lv2
	ob_start();
	record( 'lv'.ob_get_level(), 'c' ); // lv3
	ob_end_flush();
	record( 'lv'.ob_get_level(), 'd' ); // lv2
	ob_end_flush();
	record( 'lv'.ob_get_level(), 'e' ); // lv1
	ob_end_flush();
	record( 'lv'.ob_get_level(), 'f' ); // lv0
	ob_start();
	record( 'lv'.ob_get_level(), 'g' ); // lv1
	ob_start();
	record( 'lv'.ob_get_level(), 'h' ); // lv2
	ob_end_clean();
	record( 'lv'.ob_get_level(), 'i' ); // lv1
	ob_end_clean();
	record( 'lv'.ob_get_level(), 'j' ); // lv0
	// `ob_end_clean` 和 `ob_end_flush` 都会推出当前 `ob`
}


// effect();
// 操作某一层ob 会对其 上下层有什么影响
function effect() {
	// context: output_buffering=On
	record( 'lv.'.ob_get_level(), 'a' ); // lv.1
	echo 'a<br/>';
	record( ob_get_contents(), 'a.record' );
	
	ob_start();
	record( 'lv.'.ob_get_level(), 'b' ); // lv.2
	echo 'b1<br/>';
	record( ob_get_contents(), 'b1.record' ); // 不能获得到 lv.1 的内容
	ob_flush(); // 刷新 lv.2 ，将内容压入 lv.1，后面可知
	record( ob_get_contents(), 'b1.record' );
	echo 'b2<br/>';
	record( ob_get_contents(), 'b2.record' );
	ob_clean(); // 清空 lv.2，当前缓存区的内容丢失
	record( ob_get_contents(), 'b2.record' );
	record( 'lv.'.ob_get_level(), 'b' ); // 没有 ob_start 和 ob_end_xxx，依然是 lv.2
	
	ob_end_clean();
	record( 'lv.'.ob_get_level(), 'c' ); // lv.1
	record( ob_get_contents(), 'c0.record' ); // 内容：a<br/>b1<br/>；可见 lv.2 中的 ob_flush 将内容压入 lv.1
	ob_flush(); // => apache
	record( ob_get_contents(), 'c0.record' );
	echo 'c1<br/>';
	record( ob_get_contents(), 'c1.record' );
	ob_clean();
	record( ob_get_contents(), 'c1.record' );
	
	// 最终输出：a<br/>b1<br/>
	
	// 结论： 
	// 1. ob_start 开启新ob时，lv.2 不能 获取和操作 lv.1 的内容；只有当 lv.2 使用 ob_flush 时，会将自己的内容压入 lv.1。
	// 3. 使用 `ob_end_clean` `ob_end_flush` `ob_get_clean` `ob_get_flush` 都会结束当前 ob 【↓见例二】
	// 2. phper操作的 ob 永远是最上层的。 ob嵌套结构 其实是一个 栈结构 【important】
}


// close();
// 关闭当前ob的方法
function close() {
	// context: output_buffering=On
	record( 'lv.'.ob_get_level(), 'a' ); // lv.1
	ob_start();
	record( 'lv.'.ob_get_level(), 'b' ); // lv.2

// 	ob_clean(); // lv.2
// 	ob_get_clean(); // lv.1
// 	ob_end_clean(); // lv.1
// 	ob_flush(); // lv.2
// 	ob_get_flush(); // lv.1
	ob_end_flush(); // lv.1
	
	record( 'lv.'.ob_get_level(), 'c' );
}

exit;
?>


