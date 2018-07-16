<?php
trait HelloWorld {
    public function sayHello() {
        echo 'Hello ';
    }
    
    private function sayWorld() {
    	echo 'World!';
    }
}

// 修改 sayHello 的访问控制
class MyClass1 {
    use HelloWorld { sayHello as protected; }
}

// 给方法一个改变了访问控制的别名
// 原版 sayHello 的访问控制则没有发生变化
class MyClass2 {
    use HelloWorld { sayWorld as public sayWorlddd; }
}

$c2 = new MyClass2();
// $c2->sayWorld();
$c2->sayWorlddd();
?>