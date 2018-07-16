<?php

ob_get_level()==0 && ob_start();
$post_data = file_get_contents('php://input');
print_r($post_data);
print_r($_POST);
$log = ob_get_clean();

$fh = fopen('./fuyou.log','a+');
fwrite($fh, $log);

exit('1');

