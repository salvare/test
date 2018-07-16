<?php
namespace ns\a;

require 'public.php';

include_once './a.php';
include_once '../n.php';
include_once '../t.php'; // Cannot redeclare r() // <- 没报错啊，PHP5.6


a(); // ns\a\a()
r(); // ns\a\r()
\ns\a\r(); // ns\a\r()
\r();
// ↑ 可以直接调用同命名空间的函数

\t(); // t:t()
t(); // t:t()
// ↑ 可以直接调用根命名空间的函数

// ↑ 所以子命名空间中 函数不能与 根命名空间重复 ？！ <- 现在看是可以的


new A(); // ns\a\A
new R(); // ns\a\R
new \R(); // t:R
// new T(); 
new \T();
// ↑ 类和函数不一样，根空间的类必须要用 \ClassName 