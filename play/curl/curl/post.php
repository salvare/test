<?php

/*
 * CommandLine Uniform Resource Locator 命令行统一资源定位器
 * curl是利用URL语法在命令行方式下工作的开源 文件传输工具
 */
require 'public.php';

$post_data = "from the new world=abc&hello=world";
// $post_data = "username=zhangsan&password=123456";
$header = [
	'HTTP_SALVARE: city over sky',
	'FOO_BAR: baz qux',
	'BAZ-QUX: no underline'
];

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, DOMAIN.'/curl/server.php?from=post' ); // 
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt( $ch, CURLOPT_HEADER, 1 ); 
curl_setopt( $ch, CURLOPT_HTTPHEADER, $header);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
$rt = curl_exec($ch);

print($rt);