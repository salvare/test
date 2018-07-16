<?php

// include_once '../../public/public.php';

session_start();
$result_array = array(
	'session_name' => session_name(),
	'session_id' => session_id(),
);

echo $_GET['callback']."(".json_encode($result_array).")";

// welcome to api.test.com !
?>