<?php 
/*
 * js和jquery的 事件绑定和事件监听
 */
require 'public.php';
require 'head.php';
?>

<span id="yuanEvent">yuan</span>
<span id="watcher" onclick="say_hello(this,event)" >watcher</span> <!-- say_hello.bind(this)(this,event) -->
<span id="" onclick="foo()">foo</span>

<script>
$(function(){ 
// 	test1() 
// 	test2() 
// 	test3() 
	test4() 
// 	test5() 
});

// 事件绑定
var test1 = function() { 
	var btn = document.getElementById("yuanEvent"); 
	btn.onclick = eventOne
	btn.onclick = eventTwo
	btn.onclick = eventThree // this = #yuanEvent
}

// 事件监听
var test2 = function() {
	var btn = document.getElementById("yuanEvent"); 
	btn.addEventListener( "click", eventOne ); 
	btn.addEventListener( "click", eventTwo ); 
	btn.addEventListener( "click", eventThree ); // this = #yuanEvent
	btn.removeEventListener( "click", eventTwo ); 
	console.log(btn.onclick) // null
}

// jquery 事件监听
var test3 = function() {
	$("#yuanEvent").on( "click", eventOne );
	$("#yuanEvent").on( "click", eventTwo );
	$("#yuanEvent").on( "click", eventThree ); // this = #yuanEvent
	$("#yuanEvent").off( "click", eventOne );
}


// 对比
var test4 = function() {
	console.log( document.getElementById("watcher").onclick ); // ƒ onclick(event) { say_hello(this,event)  } <= ƒ onclick(event) { window.say_hello(this,event)  }
	console.log( say_hello ); // ƒ say_hello(ele,event) {...}
	// ↑ 在html元素中通过`onclick`属性设置点击事件，实际上是定义一个新函数在其中调用`say_hello` 
	$("#watcher").on( "click", function(eventt){
		console.log(eventt); // eventt 和 event 都是事件对象，但略有不同 ( p.Event vs MouseEvent ) 【前者大概经过jquery包装】
		console.log(event); // 自带了局部变量？！！ 还是说event是个全局变量 【后者，window.event】
		console.log(this); // #watcher
	});
	// 先调用了 `say_hello`
}
function say_hello(ele,event) { // 参数event也是，在传入时就是event变量？！！ 【已解决】
	console.log("say_hello")
	console.log(ele); // #watcher
	console.log(event); // MouseEvent
	console.log(this); // window
}
function foo() {
	console.log(event) // 其实是window.event
	console.log(arguments) // 也没有隐式的传入event作参数
}

// jquery 自定义事件
var test5 = function() {
	$("#yuanEvent").on( "yuan", function(){
		console.log("yuan事件");
	});
	$("#yuanEvent").on( "click", function(){
		$(this).trigger("yuan"); // 在所有目标行为中，添加trigger <= 其实没有想到合适的用法，总有可以替代自定义事件的一般方法。。。 【现在看来很有意义啊】
	});
}


function eventOne(){ 
	console.log("第一个事件"); 
}
function eventTwo(){ 
	console.log("第二个事件"); 
} 
function eventThree(){ 
	console.log("第三个事件"); 
	console.log(this)
} 


</script>