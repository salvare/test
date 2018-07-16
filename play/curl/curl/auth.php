<?php
require 'public.php';

/*
 * 访问有HTTP认证的页面
 * 
 * 参考： https://secure.php.net/manual/zh/features.http-auth.php【excellent】【manual】
 * 		http://www.php.cn/php-weizijiaocheng-359900.html【php页面访问控制的3种方法】【good】
 * 		http://blog.csdn.net/b_dogs881221/article/details/7753847【HTTP认证机制】
 * 		http://www.oschina.net/code/piece_full?code=44455【第4条 抓取一些有页面访问控制的页面】
 */

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, DOMAIN.'/curl/server.php?from=auth' );
curl_setopt( $ch, CURLOPT_HEADER, 1 );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
// curl_setopt( $ch, CURLOPT_USERPWD, 'something:wrong'); 
curl_setopt( $ch, CURLOPT_USERPWD, 'hello:world'); 
$rt = curl_exec($ch);

exit;
?>
<!-- 

抓取一些有页面访问控制的页面 
如果用上面提到的方法抓的话，会报以下错误
You are not authorized to view this page
You do not have permission to view this directory or page using the credentials that you supplied because your Web browser is sending a WWW-Authenticate header field that the Web server is not configured to accept.
这个时候，我们就要用CURLOPT_USERPWD来进行验证了

HTTP认证：
* HTTP协议定义了 `Authorization`页面访问控制方法
* 可以直接在服务端脚本代码中 实现验证逻辑 `header("WWW-Authenticate: Basic realm=\"access test\"")`
* 服务器本身也提供了支持，以`httpd.conf` `.htaccess`等形式便捷的配置页面认证
* PHP 的 HTTP 认证机制仅在 PHP 以 模块方式运行时才有效，因此该功能不适用于 CGI 版本。
* 支持“Basic”和“Digest”（自 PHP 5.1.0 起）认证方法。

-->