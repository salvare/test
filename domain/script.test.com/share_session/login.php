<?php
require 'public.php';

if ( $_POST['action']=='something' ) {
	session_start();
	sleep(2);
	$_SESSION['weed'] = 'rose';
	var_dump( $_SESSION );
	exit;
}
if ( $_POST['action']=='show_session' ) {
	session_start();
	var_dump( $_SESSION );
	exit;
}
if ( $_POST['action']=='clear_session' ) {
	session_start();
	$_SESSION = [];
	exit;
}

session_start();
$session_id = session_id();
dump($session_id);

$_SESSION['access'] = true;

include_once 'head.php';
?>

<div><a href="http://script.test.com/share_session/welcome.php" target="_blank">welcome to script.test.com</a></div>
<div><a href="http://api.test.com/share_session/welcome.php" target="_blank">welcome to api.test.com</a></div>

<div>
	<button onclick="show_session()">show</button>
	<button onclick="clear_session()">clear</button>
</div>
<div id="container"></div>

<script>
sso();
do_something_within_domain();

function sso() {
	$.ajax({
		url : "http://api.test.com/share_session/sso.php",
		data : { session_id:'<?php echo $session_id;?>' },
		type : "post",
// 	 	dataType : "jsonp",    //跨域json请求一定是jsonp
// 	 	jsonp : "callback",    //跨域请求的参数名，默认是callback
		xhrFields: {
            withCredentials: true
        },
		async : true,
		success : function(data) {
// 			console.log( data );
			$("#container").append("<div>out site</div>");
		}
	});
}

function do_something_within_domain() {
	$.post( "./login.php", {action : "something"}, function(data){
// 		console.log(data);
		$("#container").append("<div>in site</div>");
	});
}

function show_session() {
	$.post( "./login.php", {action : "show_session"}, function(data){
		console.log(data);
	});
}

function clear_session() {
	$.post( "./login.php", {action : "clear_session"}, function(data){
		location.reload();
	});
}
</script>