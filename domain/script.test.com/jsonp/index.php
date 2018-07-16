<?php

include_once 'public.php';

// header( 'Access-Control-Allow-Origin', '*' );

// ini_set( 'session.cookie_domain', 'test.com' );

session_start();
// $_SESSION['moments'] = 'dream';
// var_dump($_SESSION);

include_once 'head.php';

?>

welcome to script.test.com !

<script>

$.ajax({
	url : "http://api.test.com/",
// 	data : { 'a':1, 'b':2, 'c':3 },
// 	crossDomain: true,
	dataType : "jsonp",    //跨域json请求一定是jsonp
	jsonp : "callback",    //跨域请求的参数名，默认是callback
	async : false,
	success : function(data){
		console.log( data );
	}
});

</script>