<?php
/*
 * 对象变量引用
 */
require 'public.php';

class H {
	public $a;
	function __construct($p) {
		$this->a = $p;
	}
}

function test($p) {
	$p->a = 'black';
}

function fly($p) {
	return $p;
}

$c1 = new H('hello');

// $c2 = $c1; // 等同于 $c2 = &$c1  
// dump($c2->a);
// $c1->a = 'world';
// dump($c2->a);

// test($c1); // 等同于 function test(&$p) {}
// dump($c1->a);

// $r = fly($c1);
// $c1->a = 'berry'; // 等同于 function &test($p) {}
// dump($r->a);


