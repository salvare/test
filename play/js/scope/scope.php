<?php
/*
 * 讨论 在标签中、外部文件中、iframe中 定义的js函数的 作用域
 */
 
require 'public.php';

?>

<script src="./wish.js"></script>

<script>

// inside(); 

function inside() {
	console.log("inside");
}

// inside(); 

// outside();

</script>

<!-- <script src="./wish.js"></script>  -->

<body>

	<h1 id="parent">parent</h1>
	<div>
		<span onclick="inside();">inside</span>
		<span onclick="outside();">outside</span>
	</div>
	
	<iframe name="child_frame" src="./frame.php"></iframe>

</body>

<!-- <script src="./wish.js"></script>  -->

<script>

// function inside() {
// 	console.log("inside");
// }

// inside();

</script>
