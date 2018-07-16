<?php
/*
 * object-oriented programming
 */
 
$list = ['a','b','c','d'];
$destination = function ($request) {
	echo '------------------------------<br/>';
	dump('destination');
	dump($request);
	// ...
};
$initial = function ($passable) use ($destination) {
	echo '------------------------------<br/>';
	dump('initial');
	dump($passable);
	dump($destination);
	// 	return $destination($passable);
};

$carry = function($stack, $pipe) {
	echo '------------------------------<br/>';
	dump('carry');
	dump($stack);
	dump($pipe);
	return function ($passable) use ($stack, $pipe) {
		echo '------------------------------<br/>';
		dump('carry return');
		dump($passable);
		dump($stack);
		dump($pipe);
		if ( $stack instanceof Closure ) {
			$stack($passable);
		}
	};
};

$pipeline = array_reduce(array_reverse($list), $carry, $initial);

echo '------------------------------<br/>';
dump($pipeline);

$pipeline('hhh');
exit;




 
class Hello {
	function __construct() {
	}

	function hello($p) {
		echo 'hello,'.$p;
		return 'hana';
	}
}
$h = new Hello();
dump( is_callable( [$h,'hello'], false ) ); // ['hellooo','hello']
// $funcname('kitty');
$rt = call_user_func_array( [$h,'hello'], ['kitty'] );
dump($rt);
exit;




// http://blog.csdn.net/fdipzone/article/details/14643331
$some_var_name = 1; //
// dump( $some_var_name===$GLOBALS['some_var_name'] ); // true
dump( get_defined_vars() ); // 等同于 $GLOBALS
// dump( $GLOBALS );

function some_func() {
	$some_local_var = 2;
	$_GET['hi'] = 'siri';
	$GLOBALS['blood'] = 'ban';
	// 	dump( $GLOBALS['some_var_name'] );
	dump( get_defined_vars() ); // 当前栈的"符号表"（活动符号表）； 不含全局变量
}
some_func();
exit;



Class H {
	public $p1=1;

	function hello() {
		dump('hello');
	}

	function test() {
		// 		dump(self);
		self::hello();
		// 		self->hello();
		$this::hello();
		$this->hello();
	}
}

$h = new H();
$h->test();
$h::test();
exit;