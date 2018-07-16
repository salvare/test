<?php

$handle_a = fopen('./thinkphp.txt','w+');
fwrite($handle_a, 'mmm');

file_put_contents('php://fd/3', '333');
file_put_contents('php://fd/0', '000');
file_put_contents('php://fd/1', '111');
file_put_contents('php://fd/2', '222');
