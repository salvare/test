<?php
require 'public.php';

/*
 * 服务器端可以通过 HTTP 协议读写 cookie
 * 
 * 读操作只能获得`key`和`value`，写操作可以控制`expires`等
 * 相关：	/play/curl/curl/session.php
 * 		/play/curl/server.php
 */

// 方法一
// setCookie(
// 	'night',		// key
// 	'wish', 		// value
// 	time()+120, 	// expire
// 	'/', 	// path
// 	'play.com', 	// host
// 	false,			// secure: the cookie should only be transmitted over a secure HTTPS connection from the client 【意义不明】
// 	true			// http-only: When true the cookie will be made accessible only through the HTTP protocol 【意义不明】
// ); 
// 仔细阅读setCookie方法注释  OR 参考：http://blog.csdn.net/qq_25600055/article/details/50895759
// ↑ 会覆盖session_start的写cookie操作
// 完整版 Set-Cookie:night=wish; expires=Mon, 03-Jul-2017 10:31:55 GMT; Max-Age=120; path=/foo/bar/; domain=play.com; secure; httponly

// 方法二
header( "Set-Cookie: every=time; path=/qux/; domain=".HOST."; expires=".gmstrftime("%A, %d-%b-%Y %H:%M:%S GMT",time()+120)."; httponly" );//  secure;

require 'head.php';