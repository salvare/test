<?php

class  strtoupper_filter  extends  php_user_filter  {
	function  filter ( $in ,  $out , & $consumed ,  $closing )
	{
		while ( $bucket  =  stream_bucket_make_writeable ( $in )) {
			$bucket -> data  =  strtoupper ( $bucket -> data );
			$consumed  +=  $bucket -> datalen ;
			stream_bucket_append ( $out ,  $bucket );
		}
		return  PSFS_PASS_ON ;
	}
}

/* Register our filter with PHP */
stream_filter_register ( "strtoupper" ,  "strtoupper_filter" )
or die( "Failed to register filter" );

$fp  =  fopen ( "./foo-bar.txt" ,  "w" );

/* Attach the registered filter to the stream just opened */
stream_filter_append ( $fp ,  "strtoupper" );

fwrite ( $fp ,  "Line1\n" );
fwrite ( $fp ,  "Word - 2\n" );
fwrite ( $fp ,  "Easy As 123\n" );

fclose ( $fp );


readfile ( "./foo-bar.txt" );