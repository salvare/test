<?php
include_once 'public.php';

// 例三
class H
{
	private $name = 'hello';
	
	function getClosure() {
		$sunset = 'xxx';
		return function($a) use ($sunset) {
			dump($this);
		};
	}
	
	function set_name($name) {
		$this->name = $name;
	}
}
$h = new H();
$h->set_name('cat');
$func = $h->getClosure();
$h->set_name('dog');
// dump($func);
$func(1); // hello cat dog  $this===$h

exit;
// 例一
$sunset = 'xxx'; // 会作为静态成员
$func = function() use ($sunset) {
	dump('func called');
};
dump($func); //class Closure#1 (0) { }
// $reflect =new ReflectionClass('Closure');
// var_dump(
// 	$reflect->isInterface(), //false
// 	$reflect->isFinal(), //true
// 	$reflect->isInternal() //true
// );


// 例二
class Lang
{
	private $name = 'hello';
}

$closure = function () {
	dump($this->name);
};

$bind_closure = Closure::bind($closure, $l = new Lang(), 'Lang'); // p1:匿名函数 p2:实例 p3:类名
// dump($l);
// $l->Lang();
// $study_l = new ReflectionObject($l);
// dump( $study_l->getConstructor() );
// dump( $study_l->getMethods() );
// dump( $study_l );
echo $bind_closure(); //php
