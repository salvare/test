<!-- 
入口：1.php 或 c.php
-->
<?php 
isset($p) || $p=0;
isset($canBack) || $canBack=1;
isset($canForward) || $canForward=1;
include 'public.php';
include 'head.php';
?>
<style>
a {color:blue;cursor:pointer}
</style>
<span onclick="window.history.back()">后退</span>
<span onclick="window.history.forward()">前进</span>

<script>
$("a").on("click", function() {
	history.go(1); // C->R
	let href = $(this).data("href");
	location.href = href;
})

window.onpopstate = function(event) {
	console.log("onpopstate"); // 前进/后退 都可能触发
	console.log(history.state);
	console.log(history.length);
	if (history.state.flag=="L") { // 后退
		if (history.state.canBack) { // 该页面允许后退
			console.log("back success")
			history.go(-2)
		} else { // 不允许后退
			console.log("back fail")
			alert("back fail")
			history.go(1)
		}
	}
	if (history.state.flag=="R") { // 前进
		if (history.state.canForward) {
			console.log("forward success")
			history.go(2)
		} else {
			console.log("forward fail")
			alert("forward fail")
			history.go(-1)
		}
	}
};

if ( history.state==null ) {
	let page = "<?php echo $p?>";
	let canBack = <?php echo $canBack?>;
	let canForward = <?php echo $canForward?>;
	console.log("new page " + page);
	// 构造`L-C-R`三步骤
	var stateL = { page:page, flag:'L', canBack:canBack };
	var stateC = { page:page, flag:'C', canBack:canBack, canForward:canForward };
	var stateR = { page:page, flag:'R', canForward:canForward };
	history.replaceState(stateL, "", location.href);
	history.pushState(stateC, "", location.href);
	history.pushState(stateR, "", location.href);
	// 回退到`C`步骤
	history.go(-1);
}

// alert("js is running" + history.length)
</script>

