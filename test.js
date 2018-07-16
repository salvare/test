//async function testAsync() {
////    console.log("hello async");
//    return "hello async";
//}
//
//testAsync().then(v => {
//    console.log(v);    // 输出 hello async
//});

function getSomething() {
    return "something";
}

async function testAsync() {
//    return Promise.resolve("hello async");
    return "hello async";
}

async function test() {
    const v1 = await getSomething();
    const v2 = await testAsync();
    console.log(v1, v2);
}

test();

