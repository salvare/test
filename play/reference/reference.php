<?php
require 'public.php';

/*
 * & 是否可以理解为 “取地址符”？
 */

// f1();
function f1() {
	$a = 1;
	$b = &$a;
	
	$a = 2;
	dump($a); // 2
	dump($b); // 2
	
	$b = 3;
	dump($a); // 3
	dump($b); // 3
	
	unset($a);
	dump($a); // NULL 
	dump($b); // 3 【意外！】
	
// 	dump( &$a ); // Fatal error: Call-time pass-by-reference has been removed in ...
	// ↑ php.ini 中 allow_call_time_pass_reference=true 会导致apache启动时崩溃
	// ↑ https://zhidao.baidu.com/question/418797126.html
}

f2();
function f2() {
	$a = new A();
	dump( get_defined_vars() );
// 	$b = $a;
	$b = &$a;
	dump( get_defined_vars() ); // 注意：$a被引用之后，$a自身状态（打印结果中出现一个 & ）也发生变化
	
	$a->p1 = 2;
	dump($a); // obj
	dump($b); // obj

	$b = 3;
	dump($a); // obj
	dump($b); // 3
	
}
class A {
	public $p1 = 1;
}

// f3();
function f3(){
	error_reporting(E_ALL);
	$a = $arr['aaa']['bbb']; // Notice: Undefined variable: arr in C:\xampp\htdocs\test\test.php on line 5
	echo '<br/>-----<br/>';
	$a = &$arr['aaa']['bbb']; // 不会报错
}


?>
<!-- 

看到 `&` 符号，再看到它在`PHP`中的用法：变量的引用，函数传址调用，函数引用返回；很容易让人联想到`C语言`中的“取地址符&”。
但是`PHP`中，没有 `地址address`概念，但是是有`引用reference`概念。

@ 关于 `引用reference`：
http://www.cnblogs.com/gw811/archive/2012/10/20/2732687.html 【C++引用详解】
http://blog.csdn.net/haoxinqingb/article/details/7716856 【C语言没有引用,C++才有引用】
http://bbs.csdn.net/topics/380132723 【c语言有引用吗】
↓ 摘录
* 引用：就是某一变量（目标）的一个别名，对引用的操作与对变量直接操作完全一样。
* c没有引用，c++引用底层也是指针实现 
* c++中引用的语法 `int &ra=a;`。`ra`是`a`的引用 
  ↑ printf("%x %x", ra, a); // ra和 a的地址相同？

`PHP`中`reference`的概念符合 `c++`中的定义（但是语法有差异）。
↑ int &b = a; // c++ 引用
  int *p = &a; // c/c++ 取地址
  $b = &a; // php 引用

结论： `&`在PHP中 只用 `reference`的含义，没有取地址的含义


-->
