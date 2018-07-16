<?php
include_once 'public.php';
header( 'Access-Control-Allow-Origin: http://script.test.com' );
header( 'Access-Control-Allow-Credentials: true');

// var_dump($_POST);
session_id( $_REQUEST['session_id'] ); 
session_start();

$_SESSION['flower'] = 'lotus';
var_dump($_SESSION);
// var_dump(session_id());

sleep(1);
exit;