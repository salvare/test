<?php
require 'public.php';

/*
 * @ chrome的 伪断点下载功能
 * @ 本节在`download`方法中额外添加了测试代码，搜索`fake_flag`可找到，测试完成请注释测试代码
 */

// fake();
function fake() {
	$file_path = RES_PATH.'/demo.mkv';
	download($file_path, 512);
}


if_limit_time();
function if_limit_time() {
	set_time_limit(60);
	$file_path = RES_PATH.'/demo.mkv';
	download($file_path, 512);
}

?>

<!-- 

@ 使用chrome访问下载页面时，会弹出一个下载板块 或 一个下载控制页面 `chrome://downloads/`
* 在该页面中，可以控制 `暂停/继续` 和 `取消`；这里的 `暂停/继续` 功能，不是由断点续传实现的 
* 在暂停时，它其实一直保持请求没有中断
  . 但是不知道用了什么方法，使得传输中止了。
  . 客户端有方法可以控制服务器端的传输？ 
  . 比如本地处理数据速度慢的话，需要有一个机制告诉服务器停止传输，以免被数据淹没
  
@ 在download的输出循环中，加入`record`
* 代码见 `function -> download`，记录见 `./temp`
* 观察到在 客户端点击暂停时，服务器端代码也被阻塞
  
@ 查阅一定资料，猜测`HTTP`做不到这种行为
* 另外，浏览器在处理下载页面时，关闭了原来的请求 (Timing面板：Content Download 0.87ms)，然后转交“下载控制页面”处理
* 有可能是 `TCP` 协议控制的

-->