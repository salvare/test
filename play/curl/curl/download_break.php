<?php
require 'public.php';

/*
 * 断点续传
 * 
 * 关键字: Range, Accept-Ranges, Content-Range, ETag, If-None-Match
 * 参考： http://www.cnblogs.com/Creator/p/5490929.html【HTTP文件断点续传的原理】【excellent】【原理及应用】
 * 		http://www.cnblogs.com/xyxiong/archive/2011/02/16/1956167.html 【PHP 关于文件上传下载 断点续传问题】【good】【提供代码】
 */

$resource = 'http://www.play.com/download/download.php';
break_dynamic($resource);
// 断点下载动态资源
function break_dynamic($resource) {
	// first
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $resource );
// 	curl_setopt( $ch, CURLOPT_HEADER, true );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_RANGE, '0-5' );
	$rt = curl_exec($ch);
	curl_close($ch);
// 	echo $rt;exit;
	
	// second	
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $resource );
	// curl_setopt( $ch, CURLOPT_HEADER, true );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_RANGE, '6-' );
	$rt .= curl_exec($ch);
	curl_close($ch);
	echo $rt;
}


// $resource = 'http://img.test.com/res/demo';
// break_static($resource);
// 静态资源
function break_static($resource) {
	// first
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $resource );
	curl_setopt( $ch, CURLOPT_HEADER, true );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_RANGE, '0-5' );
// 	curl_setopt( $ch, CURLOPT_HTTPHEADER,['If-None-Match: 10-5536195d8ca44','If-Modified-Since: Mon, 03 Jul 2017 03:44:34 GMT']); // 想尝试能否像浏览器一样获取304响应的，失败了
	$rt = curl_exec($ch);
	curl_close($ch);
// 	echo $rt;exit;
	
	// second
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $resource );
	// curl_setopt( $ch, CURLOPT_HEADER, true );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_RANGE, '6-' );
	$rt .= curl_exec($ch);
	curl_close($ch);
	echo $rt;
}

exit;
?>
<!-- 

在 `break_dynamic` 一例中：
server和client都可以控制，显得`HTTP断点续传机制`(RANGE: 0-5; Accept-Ranges: bytes, Content-Range: bytes 0-5/16)，与其说是协议，更像是一个应用规范；
因为实现这个思路，可以在每次请求中，用简单的 `RANGE: 0-5` 参数获取内容，而上述 `request/response header` 中很显然提供了更丰富的内容，和更严谨的控制；
在这个情形（脚本处理的动态资源）下，断点续传机制没有太大意义，只要根据业务需求设计程序就好（当然也可以仿照机制的规范）。

于是 `break_static` 例子中试图下载静态资源：
服务器对于 `RANGE: 0-5` 能自动响应  `206 Partial Content` 和  `Content-Range: bytes 0-5/16`，并正确返回相应范围的数据；

但是，浏览器的一般下载请求，是不会带有 `Range` 头的。
那么断点续传机制一般应用于什么场景呢？
↑ 比如视频网站，可以加载部分数据，即时播放，并按一定机制间断加载数据，记录每次请求的`Range`

附带，客户端验证资源是否变动的方法 - `ETag`：
常用于缓存机制；
服务器初次响应时，会附带`ETag`字段，值是内容的特征码（比如hash）；
客户端再次请求时，用 `If-None-Match`携带保存的 特征码，如果服务器发现 `If-None-Match`和 当前的`ETag`相同，就返回 `304 Not Modified`；
浏览器根据响应做出处理；如果是`304`，则使用缓存；如果是`200`，则处理响应的数据；
当然，也可能有别的机制需要判断 请求的资源是否发生变化，如上述断点续传，业务可能要求如果资源发生改变，要求客户端从头接收数据，不能从断点处开始


附： 断点续传 response header 示例
HTTP/1.1 206 Partial Content
Date: Mon, 03 Jul 2017 03:44:36 GMT
Server: Apache/2.4.17 (Win32) OpenSSL/1.0.2d PHP/5.6.19
Last-Modified: Mon, 03 Jul 2017 03:44:34 GMT
ETag: "10-5536195d8ca44"
Accept-Ranges: bytes
Content-Length: 6
Content-Range: bytes 0-5/16


-->