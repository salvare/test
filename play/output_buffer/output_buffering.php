<?php
require 'public.php';

/*
 * php.ini 的 output_buffering 配置
 */

// ob_on();
// output_buffering=On
function ob_on() {
	echo str_repeat('x', 1024*4*10);
	$contents = ob_get_contents();
	ob_clean();
	dump($contents);	
}


// ob_off();
// output_buffering=Off
function ob_off() {
	echo str_repeat('x', 8);
	$contents = ob_get_contents();
	ob_clean();
	dump($contents); // false
}


ob_8();
// output_buffering=8
function ob_8() {
	echo str_repeat('x', 7); // 被ob_get_contents捕捉
// 	echo str_repeat('x', 8); // 成功输出
	$contents = ob_get_contents();
	ob_clean();
	dump($contents);
}

exit;
?>
<!-- 

@ 流程
`echo` -> `php缓存` -ob_flush-> `apache缓存` -flush-> `客户端`


@ php.ini 中的 output_buffering 和 implicit_flush 配置
* output_buffering=On | Off | Integer	//设置php的输出缓存区
  . On 开启。不限制缓存区的大小，直到ob_flush()命令才将内容输出到Apache
  . Off 关闭。不使用php缓存区，【此时具体流程不明。。】
  . Integer 开启。限制缓存去大小，当输出缓存区的内容超过限额，会自动发往apache
* implicit_flush=Off | On //配置apache的缓存区
  . on 自动刷新apache缓冲区,也就是,当php发送数据到apache的缓冲区的时候,不需要等待其他指令,直接就把输出返回到浏览器
  . off 不自动刷新apache缓冲区,接受到数据后,等待刷新指令flush()


@ 相关函数
* ob_implicit_flush(true|false);
同开启/关闭php.ini implicit_flush=On|Off
* flush();
命令apache刷新其缓存区（即清空缓存区 并发送给客户端）
* ob_start();
同output_buffering=On
* ob_flush();
命令php刷新输出缓存区
* ob_clean();
清空输出缓存区
* ob_get_contents()
获取输出缓冲区的内容
* ob_end_clean();
同output_buffering=Off,同时清除（就是没了）缓存区现有内容
* ob_end_flush();
ob_flush() + ob_end_clean()
* ob_get_clean();
ob_get_contents() + ob_end_clean()
# 参考：http://www.cnblogs.com/saw2012/archive/2013/01/30/2882451.html
# 手册：http://php.net/manual/zh/ref.outcontrol.php#ref.outcontrol



-->