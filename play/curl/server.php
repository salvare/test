<?php
require 'public.php';

if ( $_GET['from']=='post' ) {
	
	// method
	if(IS_POST) 
		watch("post success");
	else
		watch("post fail");
	
	// request-header
	watch( getallheaders(), 'request-header' ); // 有些运行模式不支持
// 	print_r( apache_request_headers() ); // apache_request_headers===getallheaders
// 	print_r( $_SERVER ); // 自定义的header不能包含 “下划线”； From: http://www.58cm.cn/archives/191.html
// 	var_dump( $_SERVER['HTTP_BAZ_QUX'] ); // $_SERVER: BAZ-QUX -> HTTP_BAZ_QUX
	
	// request-body
	watch( file_get_contents('php://input'), 'request-body' );
// 	print_r( $GLOBALS['HTTP_RAW_POST_DATA'] ); // This feature was DEPRECATED in PHP 5.6.0, and REMOVED as of PHP 7.0.0.
	
	// form
// 	echo '[form] ';
// 	print_r( $_POST );
	watch( $_POST, '$_post'); // 1.格式： key1=val1&key2=val2; 2.key中的空格会自动转为下划线
	
	exit;
}

if ( $_GET['from']=='upload' ) {
	watch( file_get_contents('php://input'), 'request-body' ); // 空？！！
	watch( getallheaders(), 'request-header' ); // multipart/form-data; boundary=------------------------ab7178e28ef6b41c
	watch( $_POST, '$_POST'); // baz=>hhh
	watch( $_FILES, '$_FILES'); // foobar=>Array
	exit;
	$filename = mb_convert_encoding( $_FILES['foobar']['tmp_name'] , 'GBK', 'utf8' );
	$destination = mb_convert_encoding( __DIR__.DIRECTORY_SEPARATOR.'curl'.DIRECTORY_SEPARATOR.$_FILES['foobar']['name'], 'GBK', 'utf8' );
// 	watch( realpath( './curl/'.$_FILES['foobar']['name']) ); // false
// 	watch( realpath( './curl/attachment') ); // realpath的参数必须是一个真实存在的文件
	if ( file_exists($destination) ) 
		unlink($destination);
	move_uploaded_file( $filename, $destination );
	exit;
}

if ( $_GET['from']=='session' ) {
	
	session_start(); // 只有php脚本开启session时，才会向cookie写入PHPSESSID Friday,23-Jun-2017 07:26:18 GMT
	// ↑ 另外，如果读出 `$_COOKIE['PHPSESSID']`已经存在时，则不会创建新的PHPSESSID
	
	watch( $_SESSION, '$_SESSION' );
	watch( session_id(), 'session_id' );

	if ( $_SESSION['username'] ) { // 进入系统
		watch( "welcome,{$_SESSION['username']}!" );
	} else { // 登陆
		if ( $_POST['username'] && $_POST['password'] ) { // 就当验证过了
			$_SESSION['username'] = $_POST['username'];
		}
	}

// 	watch( getallheaders(), 'request-header' );
// 	watch( $_COOKIE, '$_COOKIE' );
	
	// 尝试一下设置cookie
// 	header( "Set-Cookie: every=time; path=/baz/; domain=".HOST."; expires=".gmstrftime("%A, %d-%b-%Y %H:%M:%S GMT",time()+120) );
// 	setCookie(
// 		'night',		// key
// 		'wish', 		// value
// 		time()+120, 	// expire
// 		'/foo/bar/', 	// path
// 		'play.com', 	// host
// 		false,			// secure: the cookie should only be transmitted over a secure HTTPS connection from the client 【意义不明】
// 		false			// http-only: When true the cookie will be made accessible only through the HTTP protocol 【意义不明】
// 	); // 仔细阅读setCookie方法注释  OR 参考：http://blog.csdn.net/qq_25600055/article/details/50895759
	// ↑ 会覆盖session_start的写cookie操作
	
	exit;
}

if ( $_GET['from']=='proxy' ) {
	exit('hello kitty');
}

if ( $_GET['from']=='auth' ) {
	
	watch( getallheaders(), 'request-header' ); // [Authorization] => Basic MjMxMTQ0OjIwOTFYVEFqbWQ9
	// ↑ `CURLOPT_USERPWD`选项添加了`Authorization`头； 
	// ↑ `MjMxMTQ0OjIwOTFYVEFqbWQ9` 是 `user:pwd`字符串经某种编码所得
	
	watch( $_SERVER, '$_SERVER' ); 
	// `Authorization`头被解释为：`$_SERVER['PHP_AUTH_USER']` 和 `$_SERVER['PHP_AUTH_PW']`
	
	define('ADMIN_USERNAME','hello'); // Admin Username
	define('ADMIN_PASSWORD','world'); // Admin Password
	if ( !isset($_SERVER['PHP_AUTH_USER']) || 
		 !isset($_SERVER['PHP_AUTH_PW']) ||
		$_SERVER['PHP_AUTH_USER'] != ADMIN_USERNAME ||
		$_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD ) {
			header("WWW-Authenticate: Basic realm=\"access test\""); // 如果是浏览器的话 会弹出“需要进行身份验证”弹框，如果验证通过则携带`Authorization`头重新请求
			header("HTTP/1.0 401 Unauthorized"); 
			echo "<html><body><h1>Rejected!</h1><big>Wrong Username or Password!</big></body></html>";
			exit;
	}
	
	watch( 'welcome!' );
	// 浏览器会缓存 `Authorization`，再次访问该页面时不需要重新填写,有效时间不明，机制不明
	
	exit;
}

if ( $_GET['from']=='auth_digest' ) {
	// 注意：chrome不支持，firefox支持

	watch( $_SERVER, '$_SERVER' );
	$realm = 'Restricted area'; // 这段可能会明文显示给客户端
	$users = array('admin' => 'mypass', 'happy' => 'tree'); //user => password
	
	// function to parse the http auth header
	function http_digest_parse($txt)
	{
		$params = explode(', ', $txt);
		$data = [];
		foreach ($params as $val) {
			$item = explode('=', $val, 2);
			$data[$item[0]] = trim($item[1],'"');
		}
		return $data;
	}
	
	function authenticate($realm) {
		header('HTTP/1.1 401 Unauthorized');
		header($h='WWW-Authenticate: Digest realm="'.$realm.
				'" qop="auth" nonce="'.uniqid().'" opaque="'.md5($realm).'"');
		watch( $h, 'header' );
		die('Text to send if user hits Cancel button');
	}
	
	// 认证
	if ( empty($_SERVER['PHP_AUTH_DIGEST']) ) {
		authenticate($realm);
	}
	
	// analyze the PHP_AUTH_DIGEST variable
	$data=http_digest_parse($_SERVER['PHP_AUTH_DIGEST']);
	watch( $data, 'digest_parse' );
	if ( !$data || !isset($users[$data['username']]) )
		die('Wrong Credentials!');
	
	// generate the valid response
	$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
	$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
	$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);
	watch( $valid_response, 'valid_response' );

	if ($data['response'] != $valid_response)
		die('Wrong Credentialsss!');

	// ok, valid username & password
	echo "Welcome: {$data['username']}";
	exit;
}

watch( $_SERVER, '$_SERVER' );

