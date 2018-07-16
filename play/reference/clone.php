<?php
/*
 * clone vs new
 */
require 'public.php';

class H {
	public static $a=0;
	public $p;
	
	function __construct($p) {
		H::$a++;
		$this->p = $p;
	}
}

$obj = new H('obj');
$obj_reference = $obj;
dump(H::$a);

$obj_2 = new H('obj_2');
dump(H::$a);

$obj_copy = clone $obj; // 不会触发构造方法
dump(H::$a);

dump($obj);
dump($obj_copy);

dump($obj==$obj_copy); // true
dump($obj===$obj_copy); // false

dump($obj==$obj_reference); // true
dump($obj===$obj_reference); // true