<?php

$handle = fopen('php://memory','rw+');
fwrite($handle, 'xxx',1024);

$content = fread($handle,1024);
var_dump($content);
