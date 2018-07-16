<?php
require 'public.php';

/*
 * 下载文件，提供了两个方法
 * 其实下载方法差不多，只是根据response的不同，取文件名的方法不同而已
 * 例子的试验目的大于实际意义
 */
 
// $resource = 'http://img.test.com/res/demo.jpg';
// down_curlopt_file($resource);
// 通过 CURLOPT_FILE 选项
function down_curlopt_file($resource) {
	preg_match('/(?<=\/)[a-zA-Z0-9.]*$/',$resource,$matches);
	$filename = $matches ? $matches[0] : 'temp';
	$handle = fopen( __DIR__.DIRECTORY_SEPARATOR.$filename, 'w+' );
	
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $resource );
// 	curl_setopt( $ch, CURLOPT_HEADER, true );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false ); // 当设置 `CURLOPT_FILE` 选项时， `CURLOPT_RETURNTRANSFER=false`，设置为true无效
	curl_setopt( $ch, CURLOPT_FILE,  $handle); // CURLOPT_FILE:这个文件将是你放置传送的输出文件，默认是STDOUT.
	$rt = curl_exec($ch);
	
	watch($rt);
	// 获取静态资源
};


$resource = 'http://www.play.com/download/download.php';
down_content_type($resource);
// Content-Disposition: attachment; filename=gps.jpg\r\n
function down_content_type($resource) {
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $resource );
	curl_setopt( $ch, CURLOPT_HEADER, true );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_HEADERFUNCTION, 'header_callback');
	$rt = curl_exec($ch);
// 	echo $rt;exit;
	$filename = $GLOBALS['filename'] ? $GLOBALS['filename'] : 'temp';
	$handle = fopen( __DIR__.DIRECTORY_SEPARATOR.$filename, 'w+' );
	fwrite($handle, $rt);
}
function header_callback($ch,$header) {
	preg_match('/^Content-Disposition.*filename=(.*)$/i', $header, $matches);
	// ↑ 搜索：Content-Disposition: attachment; filename=gps.jpg\r\n
	$matches && $GLOBALS['filename']=trim($matches[1],"\r\n");
	return strlen($header);
}

exit;
?>