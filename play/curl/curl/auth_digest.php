<?php
require 'public.php';


$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, DOMAIN.'/curl/server.php?from=auth_digest' );
curl_setopt( $ch, CURLOPT_HEADER, 1 );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
// curl_setopt( $ch, CURLOPT_USERPWD, 'something:wrong');
curl_setopt( $ch, CURLOPT_USERPWD, 'happy:tree');
curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
// curl_setopt( $ch, CURLOPT_UNRESTRICTED_AUTH, true);
// curl_setopt( $ch, CURLOPT_USERNAME, 'happy');
// curl_setopt( $ch, CURLOPT_PASSWDFUNCTION, 'pwd_callback');
$rt = curl_exec($ch);

// function pwd_callback($ch, $prompt, $length) {
// 	return 'tree';
// }

exit;
?>
<!-- 

试验失败，curl不支持？还是选项不对？

-->