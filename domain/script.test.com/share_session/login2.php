<?php
require 'public.php';

/*
 * @ 思路： 因为 `script.test.com` 与 `api.test.com` 二级域名相同
 * $ 尝试让它们共用`.test.com`域的`cookie`
 * 
 * @ 重点：PHPSESSID cookie 的 domain 能否是 父域名
 * ↑ `cookie`方面细节参考 `@ play/cookie/domain -> test6`
 * 
 * @ 测试方法： init -> show -> do sth -> show -> login -> welcome*2
 * ↑ `init`必须在第一步，否则会先执行`session_start`，生成另一个`PHPSESSID`，并被优先使用
 * $ 或者用 `advanced_login` 替代 `init` 和 `login`
 * 
 */
 

// session_start();
// ↑ 使用 `session_start`，设置的`PHPSESSID`的`domain`默认是缺省的，即当前域名：
// ↑ `Set-Cookie:PHPSESSID=qph15i2amundaakdkhs00gmpp6; path=/`


if ( $_POST['action']=='init' ) {
	// 手动设置 `PHPSESSID`
	$rand = md5( time().mt_rand(0,1000) ); // `session_start`生成的都是26位，但是长度并没有规定
	setCookie('PHPSESSID', $rand, false, '/', 'test.com', false, false); // expire=false
	
	dump($rand, 'rand'); // b4fc34ab90477bbb68e11303151ac8bd
	dump(session_id(), 'session_id'); // 空
	// ↑ `session_id()`函数如果用来获取`PHPSESSID`的话，是从`Cookie`获取字段的
	$_SESSION['happy'] = 'tree';
	// ↑ 设置SESSION无效，还是必须要 `session_start` 之后才能使用 SESSION
	exit;
}
if ( $_POST['action']=='login' ) {
	session_start();
	$_SESSION['access'] = true;
	dump( session_id(), 'session_id' );
	dump( $_SESSION, 'session' );
	exit;
}
if ( $_POST['action']=='advanced_login' ) {
	/*
	 * 为`session_start`设置参数，避免 `init` 和 `login` 分为两段的尴尬 
	 * @ 参考：http://php.net/manual/zh/session.configuration.php【very good】
	 */
	
// 	session_start( ['cookie_domain'=>'test.com'] ); 
	// ↑ 好吧，竟然无效..
	// ↓ 方案二
	session_set_cookie_params(0, null, 'test.com');
	session_start();
	
	$_SESSION['access'] = true;
	dump( session_id(), 'session_id' );
	dump( $_SESSION, 'session' );
	exit;
}
if ( $_POST['action']=='show_session' ) {
	session_start();
	dump( session_id(), 'session_id' );
	dump( $_SESSION, 'session' );
	exit;
}
if ( $_POST['action']=='clear_session' ) {
	session_start();
	$_SESSION = [];
	exit;
}
if ( $_POST['action']=='something' ) {
	session_start();
	$_SESSION['weed'] = 'rose';
	exit;
}

include_once 'head.php';
?>

<div><a href="http://script.test.com/share_session/welcome.php" target="_blank">welcome to script.test.com</a></div>
<div><a href="http://api.test.com/share_session/welcome.php" target="_blank">welcome to api.test.com</a></div>

<div>
	<button onclick="init_session()">init</button>
	<button onclick="login()">login</button>
	<button onclick="advanced_login()">advanced login</button>
	<button onclick="do_something()">do sth</button>
	<button onclick="show_session()">show</button>
	<button onclick="clear_session()">clear</button>
</div>
<div id="container"></div>

<script>

// init_session();

function init_session() {
	$.post( "", {action : "init"} );
}

function login() {
	$.post( "", {action : "login"} );
}

function advanced_login() {
	$.post( "", {action : "advanced_login"} );
}

function do_something() {
	$.post( "", {action : "something"} );
}

function show_session() {
	$.post( "", {action : "show_session"} );
}

function clear_session() {
	$.post( "", {action : "clear_session"}, function(data){
		location.reload();
	} );
}
</script>

