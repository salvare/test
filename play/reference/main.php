<?php 
/*
 * 操作符“&”的作用
 * 
 * 参考：http://www.cnblogs.com/thinksasa/p/3334492.html【good】
 */ 

//变量引用-----------
// $a = 1;
// $b = &$a;
// $a = 2;
// var_dump($a);//2
// var_dump($b);//2

// function test(&$var)
// {
//     $var++;
// }
// $a = 1;
// test($a);
// var_dump($a);//2


//函数引用-----------
// function &test()
// {
//     static $var = 0;
//     $var++;
//     return $var;
// }

// $a = test();
// var_dump($a);//1
// $a = 10;
// $a = test();
// var_dump($a);//2

// $a = &test();
// var_dump($a);//3
// $a = 10;
// $a = &test();
// var_dump($a);//11
//结论：函数引用 的作用是 将$a指向返回值在函数中的地址
//意义：（我自己猜的）$a获得$var的拷贝，而局部变量$var会在函数执行结束后注销，$var指向的数据地址因为失去所有引用也将被回收；而将$a作为新的引用指向原数据将避免“拷贝”再“注销”的开销。
//↑（不对）静态局部变量不会被回收的；如果是一般的局部变量，使用函数返回引用确实没什么意义


//对象引用-----------
// class TEST
// {
//     public $a = 1;
// }
// $obj1 = &new TEST();
// var_dump($obj1->a);//1
// $obj1->a = 2;
// var_dump($obj1->a);//2
// $obj2 = &new TEST();
// var_dump($obj2->a);//1
//没得出结论。。。好像以前有 & new class()的写法，现在不用了。。。
//不管了
//↑没有意义

//对象与普通变量的不同---------
// class A {
//     public $foo = 1;
// }
// function func1($obj) {
//     $obj->foo = 2;
// }
// $obj = new A;
// var_dump($obj->foo);//1
// func1($obj);
// var_dump($obj->foo);//2
//
// function func2($str) {
//     $str = "world";
// }
// $str = "hello";
// var_dump($str);//hello
// func2($str);
// var_dump($str);//hello
//PHP5中默认就是通过引用来调用对象；创建副本使用方法__clone()；

// class A {
//     public $foo = 1;
// }
// $obj1 = new A();
// $obj2 = $obj1;
// $obj1->foo = 2;
// var_dump($obj2->foo);//2
//结论：对象作为在“赋值”时或者做“参数”传递时，不是拷贝一份，而是将新的引用指向存储地址
//就好像普通变量带&一样  $b = &$a;  $obj1 = $obj2;


