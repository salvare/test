<?php
require_once 'public.php';

/*
 * path参数对cookie的影响
 */

// test1();
// path参数的设置 对cookie实际的path属性 的影响
function test1() {
	$path = false; // $path = null;
	// Set-Cookie:roting=girls; expires=Thu, 06-Jul-2017 01:34:03 GMT; Max-Age=600
	// 路径：/cookie 
	// 【important】默认路径 是 当前URI(/cookie/path.php)的目录 
	
	$path = '/foo';
	// Set-Cookie:roting=girls; expires=Thu, 06-Jul-2017 01:37:10 GMT; Max-Age=600; path=/foo
	// 路径：/foo
	
	$path = '/';
	// Set-Cookie:roting=girls; expires=Thu, 06-Jul-2017 01:38:09 GMT; Max-Age=600; path=/
	// 路径：/
	
	$path = '/foo/';
	// Set-Cookie:roting=girls; expires=Thu, 06-Jul-2017 01:43:23 GMT; Max-Age=600; path=/foo/
	// 路径：/foo/
	
	setCookie('roting', 'girls', time()+600, $path, false, false, false);
}


// test2();
// path对访问的影响
function test2() {
	dump($_COOKIE,'script');
// 	setcookie('happy', 'tree', time()+600, false, false, false, false);
	setCookie('roting', 'girl', time()+600, '/cookie/path/foo', false, false, false);
	/* 
	 * @试验结果
	 * 										服务端	客户端js	客户端面板
	 * /cookie/path.php <script>			×		×		√【！】
	 * /cookie/path/foo/see.php <std>		√		√		√
	 * /cookie/path/see.php <parent>		×		×		×
	 * /cookie/path/foo/qux/see.php <child>	√		√		√
	 * /cookie/path/bar/see.php <cousin>	×		×		×
	 * 
	 * @结论：
	 * 1. 子目录可以访问父目录的cookie，反之不行
	 * 2. `客户端js`对cookie的访问权限规则 与 HTTP协议的规定完全一致
	 * 3. `/cookie/path.php`毕竟是设置`/cookie/path/foo`路径cookie的脚本，竟然可以在`cookie面板`中查看到。`cookie面板`中的内容不体现cookie权限规则。
	 * 		↑ `cookie面板`将不再纳入考量
	 * 
	 * @建议：服务器端常常使用的是动态路由，URI其实已经不再能体现资源层级关系，cookie的`path`机制也没有什么使用价值，反而会造成麻烦。
	 * 		所以建议所有设置cookie都携带 `path=/`参数，避免使用当前URI路径
	 */
}

