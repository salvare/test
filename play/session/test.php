<?php
require 'public.php';

/*
 * context: session.auto_start=0
 */

// echo 'abcde';
// ob_flush();
// flush();
// sleep(5);

if ( $_GET['nosleep'] ) {
	sleep(1);
	session_start();
	exit;
}


session_start();
sleep(5);



?>
