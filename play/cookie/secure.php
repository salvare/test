<?php
require 'public.php';

// cookie_secure()
function cookie_secure() {
	$secure = true;
	setCookie('roting', 'girls', time()+600, '/', false, $secure, false);
	dump($_COOKIE);
	// Set-Cookie:roting=girls; expires=Thu, 06-Jul-2017 02:39:45 GMT; Max-Age=600; path=/; secure
	// 服务端 ×	客户端 ×
}

function cookie_httponly() {
	$httponly = true;
	setCookie('roting', 'girls', time()+600, '/', false, false, $httponly);
	dump($_COOKIE);
	// Set-Cookie:roting=girls; expires=Thu, 06-Jul-2017 02:40:59 GMT; Max-Age=600; path=/; httponly
	// 服务端 √	客户端 ×
	// 唯独 `httponly` 参数，使得 $_COOKIE 与 document.cookie 不一致
}
?>
