<?php
require 'public.php';

/*
 * 对一个域名设置cookie，观察对其 子域名 父域名 兄弟域名 的影响
 * 
 * 使用方法：
 * 1. 打开http://www.play.com/cookie/domain.php?see
 * 		 http://play.com/cookie/domain.php?see
 * 		 http://foo.play.com/cookie/domain.php?see
 * 2. 刷新页面查看 服务器端结果，控制台js查看 客户端结果
 * 3. 每个示例第一行有当前脚本地址
 */

// 用于查看 ajax 发出请求时，是否携带cookie
if ( IS_POST ) {
// 	header( 'Access-Control-Allow-Origin: *' ); // 跨域 test1
	header( 'Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN'] );// after test1
	header( 'Access-Control-Allow-Credentials: true' ); // after test1
	watch( $_COOKIE, $_POST['domain'] );
// 	watch( $_SERVER, '$_SERVER' ); // HTTP_ORIGIN 字段表示跨域ajax的源地址
	exit;
}
// 用于查看 浏览器 发出请求时，是否携带cookie
if ( isset( $_GET['see'] ) ) {
	dump( $_COOKIE );
	exit;
}

// test1();
// 父域名设置cookie（`domain`字段为自身），其 子域名 能否访问？
function test1() {
	// play.com/cookie/domain.php
	$domain = 'play.com'; 
	set_domain_cookie($domain);
	/* 
	 * @ response-header:
	 * Set-Cookie: roting=girls; expires=Wed, 05-Jul-2017 05:35:41 GMT; Max-Age=300; path=/; domain=play.com
	 *
	 * @ chrome中: 域：.play.com
	 * 
	 * @ 试验结果：
	 * 域名			JS获取	一般请求	ajax请求
	 * play.com		√		√		√
	 * www.play.com √		√		×
	 * foo.play.com	√		√		×
	 * 
	 * @ 疑问：为什么 ajax 和 一般请求 不一样？
	 * ↑ ajax在跨域请求中，默认不携带cookie/credentials
	 * ↑ 详见 *****占位*****
	 * 
	 * @ 修改（标记了`test1`的代码）后， ajax请求 和 一般请求 结果一致 
	 * 
	 * @ 结论：父域名设置cookie（`domain`字段为自身），子域名 可以访问到
	 */
}


// test2();
// 父域名设置cookie（`domain`字段为null），其 子域名 能否访问？
function test2() {
	// play.com/cookie/domain.php
	$domain = null;
	set_domain_cookie($domain);
	/*
	 * @ response-header:
	 * Set-Cookie: roting=girls; expires=Wed, 05-Jul-2017 05:35:41 GMT; Max-Age=300; path=/
	 *
	 * @ chrome中: 域：play.com
	 * 
	 * @ 试验结果：
	 * 域名			客户端js	服务端$_COOKIE
	 * play.com		√		√
	 * www.play.com ×		×
	 * 
	 * @ 结论： `Set-Cookie`头中，如果不包含 `domain` 字段，则该`cookie`只能作用于域名自身，不能作用于子域名
	 */
}


// test3();
// 子域名设置cookie（`domain`字段 为 null 或 自身），父域名 和 兄弟域名 能否访问	<= 根据`test1``test2`显然不能
function test3() {
	// www.play.com/cookie/domain.php
	$domain = 'www.play.com';
// 	$domain = null;
	set_domain_cookie($domain);
	/*
	 * @ 试验结果（两个值结果一样）：
	 * 域名			客户端js	服务端$_COOKIE
	 * www.play.com √		√
	 * play.com		×		×
	 * foo.play.com	×		×
	 * 
	 * @ 结论： 父域名 和 兄弟域名 访问不到
	 */
}


// ↑ `test1`、`test3`中，请求的`play.com/cookie/domain.php`脚本，设置`cookie`时将`domain`字段设为自身
// ↓ 那么在对某域名的请求的响应中，能不能设置其它域名的cookie呢

// test4();
// 父域名中 设置 子域名的cookie 
function test4() {
	// play.com/cookie/domain.php
	$domain = 'www.play.com';
	set_domain_cookie($domain);
	/*
	 * @ response-header:
	 * Set-Cookie:roting=girls; expires=Wed, 05-Jul-2017 07:12:43 GMT; Max-Age=600; path=/; domain=www.play.com
	 * 
	 * @ chrome中: 空
	 * 
	 * @ 试验结果：
	 * 域名			客户端js	服务端$_COOKIE
	 * www.play.com ×		×
	 * play.com		×		×
	 * foo.play.com	×		×
	 * 
	 * @ 结论：父域名中 不能设置 子域名的cookie 
	 */
}

// test5();
// 子域名 设置 父域名的cookie
function test5() {
	// www.play.com/cookie/domain.php
	$domain = 'play.com';
	set_domain_cookie($domain);
	/*
	 * @ response-header:
	 * Set-Cookie:roting=girls; expires=Wed, 05-Jul-2017 09:32:17 GMT; Max-Age=600; path=/; domain=play.com
	 * 
	 * @ chrome中: .play.com
	 * 
	 * @ 试验结果：
	 * 域名			客户端js	服务端$_COOKIE
	 * www.play.com √		√
	 * play.com		√		√
	 * foo.play.com	√		√
	 * 
	 * @ 结论：子域名 可以设置 父域名的cookie，并且同样对 父域名的“所有子域名” 可见
	 * 
	 * @ 其它：很显然 不可以为 兄弟域名设置cookie，不测试了 
	 */
}

/*
 * 总结：子域名 拥有其 父域名cookie 的所有权利（读 和 写），反之不然 
 */
 

// test6();
// 如果同时设置 子域名 和 父域名 的同名 cookie，HTTP怎么发送，服务器怎么取用？
function test6() {
	setCookie('hello', 'kitty', time()+600, '/', 'play.com', false, false);
	setCookie('hello', 'world', time()+600, '/', 'www.play.com', false, false);
	/*
	 * @ Set-Cookie
	 * Set-Cookie:hello=kitty; expires=Tue, 18-Jul-2017 02:07:27 GMT; Max-Age=600; path=/; domain=play.com
	 * Set-Cookie:hello=world; expires=Tue, 18-Jul-2017 02:07:27 GMT; Max-Age=600; path=/; domain=www.play.com
	 * 
	 * @ www.play.com
	 * $client: Cookie:hello=kitty; hello=world
	 * $server: ['hello'=>'kitty']
	 * 
	 * @ play.com
	 * $client: Cookie:hello=kitty
	 * $server: ['hello'=>'kitty']
	 * 
	 * @ foo.play.com
	 * $client: Cookie:hello=kitty
	 * $server: ['hello'=>'kitty']
	 * 
	 * @ 追加测试：调换两者上下位置
	 * $结果： `www.play.com`的服务器端取用了前者的值，
	 * 
	 * @结论：
	 * 1. 默认情况不会区分同名的多个cookie，只取用一个
	 * 2. 以第一个(header中Set-Cookie头的第一个)为准（前者覆盖后者）
	 * 3. `path`属性导致的相同问题 大概和这里一样
	 */
}


function set_domain_cookie($domain) {
	setCookie('roting', 'girls', time()+600, '/', $domain, false, false);
}

include 'head.php';
?>
<p>
	<button onclick="foo('www.play.com');">www.play.com</button>
	<button onclick="foo('play.com');">play.com</button>
	<button onclick="foo('foo.play.com');">foo.play.com</button>
</p>

<script>
console.log(document.cookie);

function foo(domain) {
	$.ajax({
		url : "http://"+domain+URI,
		data : {domain:domain},
		type : "post",
		xhrFields: { // after test1
			withCredentials: true
		},
	});
}
</script>

<!--  

@这次研究的 是个“维度”挺高的问题，体现在
* 子对父的影响，父对子的影响，兄弟对兄弟的影响
* 客户端结果 和 服务端结果
  . 客户端  js的`document.cookie`结果 和 浏览器的“网站信息”面板“Cookie”标签的结果 （设置 `http-only=true`就能体现）
  . 服务端  浏览器一般请求的结果 和 ajax后台请求结果 
* `domain`参数   空  和 自身
@姑且算是3个维度(3*4*2)。在最初不了解结论的情况下，如果假设这3个维度的是相互影响的话，测试的方案将会变得非常复杂。
@现在我们对问题已经有了一个较完整的理解，所以反过来从结果看
1° `子对父的影响，父对子的影响，兄弟对兄弟的影响`
  有三个值，但是慢慢会发现“兄弟对兄弟”这个值其实没有研究价值，兄弟域名的cookie几乎没有关系
 * 实际 2个值
2° `客户端 js 和 “网站信息”面板`
  在有关`http-only=true`的试验中，发现 两者的值 竟然不同，于是就怀疑 其它维度的条件 是不是也会造成这个情况，但实际上本文中所有例子中 这两者一直是一致的
   `浏览器请求 和 ajax请求 `
  现在已经知晓了只要对ajax做好相应设置后，两者的行为和结果是一致的
 * 实际  2个值，而且本例中实际没体现 2个值 的结果差异。。。只是觉得它们是有区别的
3° `domain参数   空  和 自身`
 * 实际 2个值
@以上并不严谨。只是想说不要一次性把太多问题搅在一起，而是一个个解决

-->



