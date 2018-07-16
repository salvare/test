<?php
require 'public.php';

/*
 * 能够 向给定url发送请求并获得响应 的几种方法的基础应用；
 * 1.curl 2.fsockopen 3.file_get_contents 4.fopen 
 */

try_curl();
// try_fsockopen();
// try_file_get_contents();
// try_fopen();

function try_curl() {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, DOMAIN."/curl/server.php");  //这里填绝对路径
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  //设置不直接输出. 默认直接输出
	curl_setopt($ch, CURLOPT_HEADER, 1);  //设置输出 报头. 默认不输出
// 	curl_setopt($ch, CURLOPT_NOBODY, false); //不接收response-body
	$result = curl_exec($ch);  //获取结果
	curl_close($ch);
	
	print($result);
}

function try_fsockopen() {
	// 句柄
	$fp = fsockopen( HOST, 80 ); // 如：www.play.com; host:域名，不能有http://; port:端口.
	// 发送 HTTP请求头
	fwrite( $fp, "POST /curl/server.php HTTP/1.1\r\n" ); // POST /foo/bar/buz.php HTTP/1.1\r\n
	fwrite( $fp, "Host: ".HOST."\r\n\r\n" ); // HOST: www.play.com\r\n\r\n
	// 响应
	while (!feof($fp)){
		$ret .= fgets($fp, 1000);
	}
	print($ret); // 完整的响应报文 header+body
	
	// 似乎比curl慢很多
}

function try_file_get_contents() {
	$ret = file_get_contents( DOMAIN."/curl/server.php" );
	print($ret); // 没有header
}

function try_fopen() {
	$fp = fopen( DOMAIN."/curl/server.php", 'r' );
	while ( !feof($fp) ) {
// 		$ret .= fread($fp, 1024);
		$ret .= fgets($fp, 1000);
	}
	print($ret); // 没有header
	// fopen发现参数是url时，在其内部调用了fsockopen，据说...
}

