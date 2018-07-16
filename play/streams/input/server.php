<?php
require 'public.php';

// var_dump($HTTP_RAW_POST_DATA); // undefined

dump( $_SERVER );
dump( file_get_contents( 'php://input' ) );

// var_dump( STDIN ); // only cli