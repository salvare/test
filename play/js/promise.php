<!-- 
https://segmentfault.com/a/1190000007678185【promise介绍--基础篇】【good】
https://blog.csdn.net/guoquanyou/article/details/60573633【Promise详解】
-->
<?php
include 'public.php';
include 'head.php';
?>
<script>
// testP()
// testS()
// testN()
// testF()
testA()

// 基础用法
function testP() {
	
let success = true; // true | false | "error"
let p1 = new Promise(
	(resolve, reject) => {
		doAsync({success:success, msg:"P"}, resolve, reject)
	}
)
let p2 = p1.then(doResolve, doReject);
// let p2 = p1.then(doResolve).catch(doReject)
console.log("p1", p1); // Promise{Status:"pending", Value:undefined} => Promise{Status:"resolved", Value:"P"}
console.log("p2", p2); // Promise{Status:"resolved", Value:undefined}
console.log("p1==p2", p1===p2) // false
let p3 = p2.then(doResolve, doReject); // 既然`p2`是`promise`对象，自然可以继续调用`then()`方法
console.log("p3", p3)

}

// `then()`的返回值
function testS() {
	
// 上例中可知`p2`不是`p1`，而是一个新的`Promise`对象
// 上例`p2`的状态(status)和`p1`相同，但是失去了值(value)
let s1 = new Promise(
	(resolve, reject) => {
		doAsync({success:true, msg:"S"}, resolve, reject)
	}
)
let s2 = s1.then(doResolveRt);
console.log("s1", s1); // ... => Promise{Status:"resolved", Value:"S"}
console.log("s2", s2); // Promise{Status:"resolved", Value:"happy"}
console.log("s1==s2", s1===s2); // false
// 结论：`s2`‘继承’了`s1`的状态(status)，并且将`doResolveRt()`的返回值作为值(value)

}

//如果`doResolve`返回的是一个`Promise`对象？
function testN() {

let n1 = new Promise(
	(resolve, reject) => {
		doAsync({success:true, msg:"N"}, resolve, reject)
	}
)
let n2 = n1.then(doResolveRtPms);
console.log("n1", n1); // ... => Promise{Status:"resolved", Value:"N"}
console.log("n2", n2); // Promise{Status:"resolved", Value:"N~"}
console.log("n1==n2", n1===n2); // false
// 结论：`n2`就是`doResolveRtPms`的返回值！！！

}

// 利用`testN`的结论，可以真正将 多层异步嵌套回调 改写成 顺序操作
function testF() {
	
let success = true; // true | false
f1().then(f2).then(f3).catch(doReject);

function f1() {
	return new Promise(
		(resolve, reject) => {
			doAsync({success:success, msg:"F1"}, resolve, reject)
		}
	)
}
function f2() {
	return new Promise(
		(resolve, reject) => {
			doAsync({success:success, msg:"F2"}, resolve, reject)
		}
	)
}
function f3() {
	return new Promise(
		(resolve, reject) => {
			doAsync({success:success, msg:"F3"}, resolve, reject)
		}
	)
}

}

// 执行顺序
function testA() {

new Promise((resolve)=>{
		console.log("A1"); // 1
		resolve("A1")
	}).then(doResolve); // 3
new Promise((resolve)=>{
		console.log("A2"); // 2
		resolve("A2")
	}).then(doResolve); // 4

// 结论：`Promise.then`的`resolve/reject`方法是异步调用的
// 但不是异步执行的，js是单线程的

}


// 业务正常/异常的回调
function doResolve(msg) {
	console.log("doResolve", msg);
}
function doReject(msg) {
	console.log("doReject", msg);
}
//带返回值的`resolve`
function doResolveRt(msg) {
	console.log("doResolveRt", msg);
	return {happy:"tree"}; // true | false | "happy" | {happy:"tree"}
}
//返回值是`Promise`的`resolve`
function doResolveRtPms(msg) {
	console.log("doResolveRtPms", msg);
	return new Promise(
		(resolve, reject) => {
			doAsync({success:true, msg:"N~"}, resolve, reject)
		}
	)
}
// 异步操作
function doAsync(data, resolve, reject) {
	setTimeout(
		()=>{
			console.log("doAsync", data.msg)
			if (data.success===true) {
				resolve(data.msg)
			} else if (data.success===false) {
				reject(data.msg)
			} else if (data.success==="error") {
// 				throw new Error(data.msg) // 这样写 `then(..., reject)` 和 `catch(reject)` 都捕捉不到的
				reject(new Error(data.msg)) // 这样可以，但是错误不被抛出的话也没什么特别的意义
			}
		}, 2000);
}
</script>