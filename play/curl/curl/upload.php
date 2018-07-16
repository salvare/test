<?php
require 'public.php';

/*
 * 参考：	https://segmentfault.com/a/1190000000635183【curl其它上传方式】【excellent】
 * 		https://segmentfault.com/a/1190000000725185【excellent】
 * 		http://www.cnblogs.com/zudn/archive/2011/09/13/2174413.html【multipart/form-data boundary 格式说明】
 */
 
// 文件
$filename = realpath('./attachment'); // C:\xampp\htdocs\test\play\curl\curl\attachment
$filename = mb_convert_encoding($filename,'GBK','utf8'); //我用的windows系统的字符编码是GBK，如果不转码可能会导致windows识别不了文件路径；realpath可以获取绝对路径，处理./ ../ 以及 window“\”作为路径分隔符的问题
$mimetype = 'text/plain';
$postname = 'attachment_upload';//上传后的文件的文件名


if ( class_exists('\CURLFile') ) {
	$data = array(
// 		'foobar' => curl_file_create( $filename, $mimetype, $postname ),
		'foobar' => new CURLFile( $filename, $mimetype, $postname ), // 同上
		'baz' => 'hhh',
	);
} else { // In PHP 5.5, the @filename method of sending a file using CURL has been deprecated. And be removed in PHP 5.6.
	$data = array(
		'my_file' => "@$filename;type=$mimetype;filename=$postname",//加@符号curl就会把它当成是文件上传处理，否则curl会认为上传的是普通数据而非文件
		'baz' => 'hhh',
	);
}
// dump($data);exit;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, DOMAIN.'/curl/server.php?from=upload' );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); //  ~~字面意思是关闭安全上传，php5.6之后必须做这个设置才能这样上传~~  
curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //server端脚本，会在$_FILES[my_file]看到上传文件的信息
$rt = curl_exec($ch);
if ( !$rt ) {
	$error = curl_error($ch);
	watch( $error, 'error' );
}
curl_close($ch);



exit;
?>
<!-- 

`curl_setopt($ch, CURLOPT_POSTFIELDS, $data);`
↑ 上传一般数据时，参数`$data`是字符串，而这里是数组格式。 是否是这个决定了`enctype`类型不同？
↑ 的确是，即使`$data`数组中没有上传文件，`request-header`中也`Content-Type: multipart/form-data; boundary=------------------------0b863822ea6e9bf7`
  cURL没有 显式地 设置post时enctype参数，而是设定：`STRING => application/x-www-form-urlencoded`，`ARRAY => multipart/form-data`
↑ 而且导致`file_get_contents('php://input')`不能获得报文了


form上传文件过程：
1.enctype="mutipart/form-data"
2.<input type="file" name="my_file/>
3.上传文件存放在服务器一临时文件目录，这个目录定义在php.ini，upload_tmp_dir="D:\Xampp\tmp"
4.文件路径存放在$_FILES而非$_POST
5.请求结束后临时文件会被删除
↑ cURL模拟的就是这个行为


-->
