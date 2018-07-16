<?php
require 'public.php';

/*
 * context: output_buffering=Off
 */


problem();
// 存在这种情况：当输出 <4Bytes 时，不能立刻显示在浏览器上
function problem() {
	ob_start();
	echo '123'; // 不能分段输出
// 	echo '1234'; // 正常的分段输出
	ob_flush();
	flush();
	sleep(2);
	echo 'abc';
	
	// 存在几种可能：
	// 1. ob_flush 失效
	// 2. flush 失效
	// 3. 浏览接收到信息但是没有渲染
}


// contrast();
// 去掉 ob_flush，与上边做对比
function contrast() {
	ob_start();
	echo '123';
	sleep(2);
	echo 'abc';
	
	// 浏览器的 显示现象 是相同的。
	// 但是查看timing面板： `Waiting 2.00s`，这表明浏览器成功发出请求后，等待2s后才得到服务器的响应；
	// ↑ 额外说明，http的响应报文由`header`(前)和`body`(后)组成，phper在脚本中输出(如：echo)的内容会存入`body`，用`header()`方法可以添加入`header`。
	// ↑ 由于先后关系，在php有输出到apache之后，`header`就不能再修改了
	// 而`problem`例子中 timing 面板：`Waiting:1.68ms` `Content Download:2.01s`，可见`echo 123`已经发送到浏览器了
}


// example();
// 观察这个例子，可以更直观的看出浏览器机制
function example() {
	$i = 1;
	while (true) {
		// 	echo str_pad(' ', 4096);
		echo $i++;
		ob_flush();
		flush();
		sleep(1);
	}
	// 浏览器等到 `sizeof response-body >= 4bytes` 时才开始渲染内容
}




