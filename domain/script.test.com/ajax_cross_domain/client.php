<?php
include_once 'public.php';



include_once 'head.php';
?>

<script>
$.ajax({
	url : "http://api.test.com/ajax_cross_domain/server.php",
// 	data : { 'a':1, 'b':2, 'c':3 },
// 	dataType : "jsonp",    //跨域json请求一定是jsonp
// 	jsonp : "callback",    //跨域请求的参数名，默认是callback
// 	crossDomain : true,
	async : true,
	success : function(data){
		console.log( data );
	}
});
</script>