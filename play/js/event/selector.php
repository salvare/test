<?php
include_once 'public.php';
include_once 'head.php';
?>

<button onclick="toggle()">toggle</button>
<ul>
	<li class="rwby">ruby</li>
	<li class="rwby">weiss</li>
	<li class="rwby">blade</li>
</ul>

<script>
$(function(){
	$(".rwby").on( "click", function(){
		console.log('victory');
	});
});

function toggle() {
	if ( $("ul").children().length==3 ) {
		$("ul").append('<li class="rwby">yang</li>'); // 是不会获得点击事件的
	} else if ( $("ul").children().length==4 ) {
		$("ul").children()[3].remove();
	}
}

/* 
 * 结论： 给“当前”所有选择到的元素添加事件，而不是给选择器永久添加事件
 */
</script>