<!-- 
只是一个pjax示例，没有对其机制深入学习
https://www.jianshu.com/p/557cad38e7dd【pjax使用小结】
-->
<?php
include_once 'public.php';

if ( IS_PJAX ) {
	$p = isset($_GET['p']) ? $_GET['p'] : 0;
	$p==0 && exit('end');
	$p==1 && exit('111');
	$p==2 && exit('222');
	$p==3 && exit('333');
} 

include_once 'head.php';
?>

<div id="main"></div>
<a href="javascript:void(0)" data-url="./pjax.php?p=1">page1</a> <!-- 使用了 href="#" chrome出错，原因大概是#..算了搞不清 -->
<a href="javascript:void(0)" data-url="./pjax.php?p=2">page2</a>
<a href="javascript:void(0)" data-url="./pjax.php?p=3">page3</a>
<a href="javascript:void(0)" data-url="./pjax.php">end</a>

<script>
$("a").on( "click", function(){
	console.log($(this).attr("data-url"));
	get( $(this).attr("data-url") );
});

get("/history/pjax.php");

function get(url) {
	// 为什么前进后退时，能自动恢复页面数据？？？ <= 经试验，前进后退时，没有发出新的请求 <= 所以是用了浏览器缓存
	$.pjax({
	 	url: url,
		container: "#main",
		cache: false, // url为php后缀就不会缓存，为txt后缀则默认使用缓存
		storage: false,
	})

	// 原生的 ajax+pushState 前进后退是 页面保持在最后一次请求，不会变动的
// 	$.ajax({
// 		url: url,
// 		dataType: 'html',
// 		beforeSend: function(xhr){
// 			xhr.setRequestHeader('X-PJAX', 'true')
// 		},
// 		success: function(data){
// 			$('#main').html(data)
// 			history.pushState(null, $(data).filter('title').text(), url)
// 		},
// 	})
}
</script>
