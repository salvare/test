<?php
require 'public.php';
include_once 'head.php';
?>

<div id="label">0</div>
<button onclick="dec()">dec</button>
<button onclick="inc()">inc</button>

<script>

counter = ( function($_) {
	var _count = 0
	var inc = function () {
		_count++
		$_("#label").html(_count)
	}
	var dec = function () {
		_count--
		$_("#label").html(_count)
	}
	var show = function () {
		console.log(_count);
	}
	return {
		inc : inc,
		dec : dec,
		show : show
	}
} ) (jQuery)

function inc() {
	counter.inc()
}
function dec() {
	counter.dec()
}

</script>

<!-- 

@ 目的
. 独立性是模块的重要特点，模块内部最好不与程序的其他部分直接交互。
. 为了在模块内部调用全局变量，必须显式地将其他变量输入模块。
# 详见 `require.js`，是该思想的具体实现

-->