<?php

include_once 'public.php';

function add($a, $b, ...$e){
	dump($a);
	dump($b);
	dump($e);
}
$args = array(1, 2, 3, 4, 5);
add(...$args);