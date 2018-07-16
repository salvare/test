<?php
use Foo\Bar\Fruit\Apple;

include_once 'public.php';
include_once __DIR__.'/autoload.php';

$apple = new Apple();
$purple = new Foo\Bar\Color\Dark\Purple(); // windows对文件名大小写不敏感
