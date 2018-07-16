<?php
require 'public.php';

/*
 * 浏览器（客户端）可以通过js操作（读写）cookie
 */
 
if ( IS_POST ) {
	watch($_COOKIE);
	exit;
}

setCookie( 'night', 'wish', time()+120, '/foo/bar/' ); // 略

include 'head.php';
?>

<p>
	<button onclick="foo();">request</button>
</p>

<script>
function foo() {
	$.post( "", function(){} );
}

// 写
function setCookie(name,value) 
{
    var Days = 30; 
    var exp = new Date(); 
    exp.setTime(exp.getTime() + Days*24*60*60*1000); 
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString(); 
    // key=value;expires=Wed, 02 Aug 2017 09:05:55 GMT
    // 该函数功能比较局限，没有办法设置 `path` 等参数
}
// 读
function getCookie(name) 
{
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
        return unescape(arr[2]); 
    else 
        return null; 
} 
// 删
function delCookie(name) 
{
    var exp = new Date(); 
    exp.setTime(exp.getTime() - 1); 
    var cval=getCookie(name); 
    if(cval!=null) 
        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
    // 删除实质上是将： 对应key的expires属性设置为一个过去时间值
}
</script>


<!-- 

@ document.cookie
* `document.cookie`对象/属性 看似是个普通的 字符串变量，如  ` "night=wish; happy=tree" `
* 但是一般的字符串操作  ` document.cookie += "; happy=tree" `，会发现无法写入
* `document.cookie` 所读到的字符串，是用于构造`request-header`给服务器的  `Cookie: night=wish; happy=tree; sun=set`，只包含 `key` 和 `value`
* 而客户端自身，还要维护cookie的过期时间 `expires` 等等，所以它有着更多的字段，和更复杂的存储结构
* 综上，js对 `document.cookie` 对象的读写是不一致的；
	对其的赋值操作，实质上是对其存储结构的追加，并且需要经过格式校验，不符合格式不能写入；
	对其的读取操作，实质上是对其存储结构的解析，获得分号分隔的键值对格式。


@ 物理存储位置
* chrome: C:\Users\当前用户\AppData\Local\Google\Chrome\User Data\Default\Cookies
* cURL: 指定的 CURLOPT_COOKIEJAR


@ 存储格式
* 不特定，只要客户端自己能读写就可以
* chrome: sqlite
* cURL: tab分隔的文本
	| 字段	| host		| match all subdomains	| path		| secure	| timestamp		| key	| value	|
	| 值		| .play.com	| TRUE					| /foo/bar/	| TRUE		| 1498205226	| xxx	| yyy	|
* 注意：但是HTTP的cookie操作的header是有特定格式的

-->