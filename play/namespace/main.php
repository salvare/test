<?php
namespace ns;

require 'public.php';

include_once './a/a.php';
include_once './b/b.php';

$a = new \ns\a\A();
$b = new \ns\b\B();

\ns\a\a();
\ns\b\b();

a\a(); // 类似相对路径，
ns\a\a(); // 不行



