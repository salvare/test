<?php
include_once 'public.php';

// session_start();

if ( IS_POST ) {
	$time1 = time(); 
	sleep(1);
	$time2 = time();
	session_start(); // 阻塞是在 session_start 时发生的
	$time3 = time();
	var_dump( $time3-$time2 );
// 	var_dump($_SESSION);
// 	$_SESSION['click'] = $_POST['click'];
// 	session_write_close();
	sleep(4);
	exit('being');
}

if ( isset($_GET['p']) ) {
	exit('welcome!');
}


include_once 'head.php'
?>

<a href="<?php URL?>?p=1" target="_blank">insite</a>
<button onclick="back();">ajax</button>

<div>
	counter:
	<span id="counter">0</span>
</div>
<div>
	click:
	<span id="click">0</span>
</div>

<script>
function back() {
	var click = parseInt( $("#click").html() ) + 1 ;
	$("#click").html(click);
	$.post( "<?php URL?>", {click:click}, function(data){
		var counter = parseInt( $("#counter").html() ) + 1 ;
		$("#counter").html(counter);
	});
}
</script>