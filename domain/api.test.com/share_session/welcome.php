<?php
include_once 'public.php';

session_start();
dump( session_id() );
dump( $_SESSION );

if ( !isset( $_SESSION['access'] ) ) {
	exit('not available!');
}

echo 'welcome to api.test.com!';

?>