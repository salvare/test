<?php
require 'public.php';

/*
 * cookie 生命周期
 */

if ( isset($_GET['see']) ) {
	dump($_COOKIE);
	exit;
}


// test1();
function test1() {
	setCookie('roting', 'girls', time()+5, '/', false, false, false);
	/*
	 * @cookie面板：
	 * 创建时间 2017年7月6日星期四 下午12:03:23
	 * 过期时间 2017年7月6日星期四 下午12:03:28
	 * 
	 * @实际在5s后失效
	 */
}


test2();
function test2() {
	setCookie('roting', 'girls', false, '/', false, false, false);
	/*
	 * @cookie面板：
	 * 过期时间：浏览会话结束时
	 * 
	 * @试验
	 * 关闭浏览器，重新打开，访问 http://www.play.com/cookie/expire.php?see时
	 * 
	 * @实际 关闭浏览器时失效
	 * @注意 当浏览器设置 “打开您上次的窗口和标签页”时，会保存关闭前的数据，包括cookie，所以依然会有效（expires依然是空）
	 * 
	 * @摘抄注释
	 * time()+60*60*24*30 will set the cookie to expire in 30 days.
	 * If set to 0, or omitted, the cookie will expire at the end of the session (when the browser closes). 
	 */
}

?>

<script>
setInterval(function(){
	console.log(document.cookie);
},1000);
</script>