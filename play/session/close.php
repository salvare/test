<?php
require 'public.php';

/*
 * 怎样关闭或删除session
 * 
 * @ 总结：						SESSION被真实删除		$_SESSION不再能真实写入		$_SESSION变量为空
 * 1. unset($_SESSION)			×					√						√
 * 2. $_SESSION = []			√					×						√
 * 3. session_unset()			√					×						√
 * 4. session_destroy()			√					√						×
 * 5. session_write_close()		×					√						×
 */

session_start();

if ( $_POST['action']=='set' ) {
	$_SESSION['foo'] = 'bar';
	dump($_SESSION,'set');
	exit;
}
if ( $_POST['action']=='unset' ) {
	unset($_SESSION); // fail
	dump($_SESSION,'unset');
	// ↑ 这里结果是null，但是`show`中可以看出SESSION没有被删除
	
	$_SESSION['baz'] = 'qux';
	dump($_SESSION,'unset');
	// ↑ 这里查看成功，但是`show`中可以看出SESSION没有添加成功
	
	// 如果再次启用呢
	session_start();
	$_SESSION['dec'] = 'inc';
	dump($_SESSION,'unset');
	// 同上，还是无效
	
	/*
	 * 结论：unset($_SESSION)后，
	 * 1. SESSION实际没有被删除，
	 * 2. `$_SESSION` 可以视为普通变量，对其的任何操作都与 SESSION值 无关
	 *   ↑ 类似没有 `session_start` 过
	 */
	exit;
}
if ( $_POST['action']=='unset_one' ) {
	unset($_SESSION['foo']); // success
	dump($_SESSION,'unset one');
	exit;
}
if ( $_POST['action']=='clear' ) {
	$_SESSION = [];
	dump($_SESSION,'clear');
	exit;
}
if ( $_POST['action']=='session_unset' ) {
	session_unset(); // success
	dump($_SESSION,'session unset');
	$_SESSION['sessunset'] = '2333'; // success
	dump($_SESSION,'session unset');
	exit;
}
if ( $_POST['action']=='destroy' ) {
	session_destroy(); // success
	dump($_SESSION,'destroy'); // $_SESSION值依然存在！
	$_SESSION['destroy'] = '6699'; // fail
	dump($_SESSION,'destroy');
	// ↑ 同样，`session_destroy`之后`$_SESSION`变量就与 SESSION值无关了
	exit;
}
if ( $_POST['action']=='write_close' ) {
	$_SESSION['write'] = 'close'; // success
	session_write_close();
	dump($_SESSION, 'write close');
	$_SESSION['close'] = 'write'; // fail
	dump($_SESSION, 'write close');
	exit;
}
if ( $_POST['action']=='show' ) {
	dump($_SESSION,'show');
	exit;
}

include 'head.php';
?>

<div>
<button onclick="do_action('set')">set</button>
<button onclick="do_action('unset')">unset</button>
<button onclick="do_action('unset_one')">unset one</button>
<button onclick="do_action('clear')">clear</button>
<button onclick="do_action('session_unset')">session unset</button>
<button onclick="do_action('destroy')">destroy</button>
<button onclick="do_action('write_close')">write close</button>
<button onclick="do_action('show')">show</button>
</div>
<div id="container"></div>

<script>
function do_action(action) {
	$.post( "", {action : action} );
}
</script>

