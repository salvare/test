<?php
require 'public.php';
require 'head.php';
?>

<button onclick="handle_click( this, window.event );">button</button>

<script>

// 全局环境中，`this`指向`window`元素
console.log( this ); // window
console.log( this===window ); // true
separator_line("全局");


// 全局中定义的 对象 和 函数，都是`window`的属性
function foo() {
	// do nothing
}
var baz = 233;
console.log( this.foo );
console.log( this.baz );
console.log( foo ); // `this`是可以缺省的，可以直接使用`window`的属性
separator_line();


// 函数中，`this`指向其调用者
function bar() { 
	console.log( this );
}
bar(); // window
var qux = {bar:function(){
	console.log( this );
}};
qux.bar(); // qux
separator_line();


// ↑ `this`的规则其实只有这些
// ↓ 看一些例子


// html中为 dom元素 设置点击事件
function handle_click(p,event) {
	console.log( p ); // document.body.children[0]
	console.log( this ); // window. 这种定义方法，一定是window的属性，所以也一定是window所调用	<= 【不一定，「定义时上下文」和「运行时上下文」不一定相同，用`bind``call``apply`方法，2017-11-24】
	console.log( event ); // window.event。 题外：event元素代表触发的事件，触发后会沿着dom树冒泡，直到window，请看`event.paths`属性；事件结束（冒泡结束）后，window.event就会被删除 <= 粗略的事件机制
}
console.log( $("button").attr("onclick") ); // 点击事件触发的是 button元素 的`onclick`方法，所以参数`this`指向`onclick`的调用者：``
console.log( document.getElementsByTagName("button")[0].onclick );
separator_line("click");


// 思考题
var name = "The Window";
var object = {
　　name : "My Object",
　　getNameFunc : function(){
　　　　return function(){
　　　　　　return this.name;
　　　　};
　　}
};
console.log( object.getNameFunc()() ); // The Window
separator_line("question-1");

var name = "The Window";
var object = {
　　name : "My Object",
　　getNameFunc : function(){
　　　　var that = this;
　　　　return function(){
　　　　　　return that.name;
　　　　};
　　}
};
console.log( object.getNameFunc()() ); // My Object
separator_line("question-2");
// FROM: http://www.ruanyifeng.com/blog/2009/08/learning_javascript_closures.html【闭包-阮一峰】


// （构造）方法 = 类 
// js是 `proto-based-object-oriented-language`，没有`class`概念
function Cat(name,age) { // 就是普通的函数
	this.name=name;
	this.age=age
};
var cat = new Cat('sakamoto',2); // 关键字`new`: 创建对象，并且让新对象调用Cat()
console.log(cat);
separator_line("class");

</script>

