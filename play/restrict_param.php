<?php
function test(array $a, H $b){
	echo "<h1>Hello,World!</h1>";
}
class H{
}

$h = new H();

// test( 1, $h );
// test( [1], 2 );
test( [1], $h );

//Catchable fatal error

// https://my.oschina.net/corwien/blog/661009