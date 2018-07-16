<?php

$handle = fopen('php://temp', 'r+');

fwrite($handle, 'hhh');
rewind($handle);
fwrite($handle, 'xx');
rewind($handle);

$content = fread($handle, 1024);

var_dump($content);