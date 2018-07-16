<?php
/*
 * cURL模拟会话，即实现session
 * 这里以模拟登陆为例
 * 
 * 参考:http://www.cnblogs.com/txw1958/p/php-cookie-login.html
 *     http://blog.csdn.net/jallin2001/article/details/6599052/【good】
 */
require 'public.php';

$cookie_file = realpath('./cookie');

// 登陆
watch( '-------------------------', 'login' );
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, DOMAIN.'/curl/server.php?from=session');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
// curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'username=salvare&password=qwertyuiop');
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
// curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
curl_exec($ch);

// 进入
watch( '-------------------------', 'visit' );
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, DOMAIN.'/curl/server.php?from=session');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
// curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
curl_exec($ch);

// 再进一次呢
watch( '-------------------------', 'visit' );
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, DOMAIN.'/curl/server.php?from=session');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
// curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
curl_exec($ch);

exit;
?>

@ 选项
* `CURLOPT_COOKIEJAR`
连接时把获得的cookie存为文件。即服务器端可以 setCookie
* `CURLOPT_COOKIEFILE`
在访问其他页面时拿着这个cookie文件去访问。即服务器端可以读取 cookie，如$_COOKIE；$_SESSION也依赖此才可用
浏览器的是默认每次提交本地cookie的，但cURL需要手动控制


@ cURL构造的cookie存储格式
字段	| host		| match all subdomains	| path		| secure	| timestamp		| key			| value
值	| .play.com	| TRUE					| /foo/bar/	| TRUE		| 1498205226	| testcookie	| xxx



