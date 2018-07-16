<script>
/*
https://segmentfault.com/a/1190000007535316【理解 JavaScript 的 async/await】【perfect!】
http://www.ruanyifeng.com/blog/2015/05/async.html【async 函数的含义和用法】【因为有前文单独看不易理解】
*/


// test1()
// test2()
// test3()
test4()

// `async`修饰方法
function test1() {

async function testAsync() {
    return "hello";
}
// 等价于
// function testAsync() {
// 	return new Promise((resolve)=>{
// 		resolve("hello")
// 	});
// }
// 等价于
// function testAsync() {
// 	return Promise.resolve("hello")
// }

const rt = testAsync();
console.log("rt", rt); // Promise{Status:"resolved", Value:"hello"}
// 调用`async`方法会返回一个`Promise`对象
// 状态(status)为`resolved`，值(value)为返回值

testAsync().then(doResolve)

}

// await
function test2() {

async function someAsync() {
    return "hello";
}
async function tesAwait() {
    const rt = await someAsync();
    console.log("rt", rt);
}
tesAwait();
/*
. `await`等待的是一个表达式
. 如果表达式的值是普通值，可以无视`await`
. 如果表达式的值是`Promise`对象
  . 阻塞后面的代码
  . 等待`Promise`对象`resolve`，将`value`作为运算结果
*/ 

}

// 对比`async function` 和 `return new Promise`
function test3() {

async function someAsync() {
	foo = 0; // 隐式全局变量
	setTimeout(()=>{foo = 10}, 1000); // 不会等待该操作完成，只是等待`resolove`而已
	return foo; // 0
}
/*
！ 本质：`async`函数不过是隐式的创建一个`Promise`并返回，再将`return xxx`替换为`resolve(xxx)`
. 局限：因为隐式的在函数末尾调用`resolve`，所以无法在异步操作的回调内调用
  . 根本不适合进行真正的异步操作
*/

function otherAsync() {
	return new Promise((resolve)=>{
		setTimeout(
			()=>{ resolve(10) },  // 异步操作的回调
			1000
		);
	});
}

async function testAwait() {
	const rt1 = await someAsync();
	const rt2 = await otherAsync();
	// ↓ `otherAsync`阻塞了1s，然后才执行`console.log`
    console.log("rt1", rt1); // 0 
    console.log("rt2", rt2); // 10
}
// 这里才是`async`的正确用法，为了`await`而不是`resolve`

testAwait()

}


// 怎么处理`reject`
function test4() {

function someAsync() {
	return new Promise((resolve, reject)=>{
		setTimeout(
			()=>{ reject(10) }, 
			1000
		);
	});
}

// 如果不处理
async function testAwait() {
	const rt = await someAsync(); // 报错
    console.log("rt", rt); // 没有执行
}
// testAwait(); 
// 报错：`Uncaught (in promise) 10`. 随后脚本停止执行

async function doAwait() {
// 	try {
// 		const rt = await someAsync();
// 	    console.log("rt", rt);
// 	} catch(e) {
// 		console.log(e) // 10
// 		console.log(typeof e) // number
// 	}

	// 或者
	const rt = await someAsync().catch((e)=>console.log(e)); // 10
	console.log(rt); // undefined
}
doAwait();
// 结论：用`catch`处理`reject`

}


/* 
. `async/await` 的优势在于处理 `then` 链
. `promise...then`的写法见`./promise.php@testF`
  . 一开始很简单
    . f1().then(f2).then(f3)
  . 但如果`f3`需要两个参数：`f2`的结果和`f1`的结果？
    . `then`在回调`resolve`或`reject`时，只会传入一个参数就是`promise.value`
    . 为了`f3`的参数，于是不得不改造`f2`
    . f1().then((v1)=>{
        return f2(v1).then((v2)=>{
          return {v1:v1, v2:v2};
        }
      }).then(f3)
  * 处理参数太难
. 但如果用`await`
  v1 = await f1()
  v2 = await f2(v1)
  v3 = await f3(v1+v2)
# https://segmentfault.com/a/1190000007535316【async/await 的优势在于处理 then 链】
  
*/






//业务正常/异常的回调
function doResolve(msg) {
	console.log("doResolve", msg);
}
function doReject(msg) {
	console.log("doReject", msg);
}
</script>