<?php

include_once 'public.php';

function add($a, $b, ...$args){
	dump($a);
	dump($b);
	dump($args);
	dump(func_get_args());
}
$args = array(1, 2, 3, 4, 5);
add(1, 2, 3);