<?php
// stdin & stdout

//STDIN STDOUT 常量只在cli模式有定义。apache2handler下undefined

fwrite(STDOUT, "Enter your name: ");
// echo "Enter your name: ";//标准输出流，在cli模式下，同echo
// get input
$name = trim(fgets(STDIN));
// write input back
fwrite(STDOUT, "Hello, $name!");