<?php

require 'public.php';


setcookie('good','noon',time()+100,'/garden/','.test.com');
setcookie('note','book',time()+100,'/','.test.com');
setcookie('full','moon');

session_start();

// unset($_SESSION);
// session_destroy();
// session_id('16j1un84mkt9khaig50lu10011');
// session_start();

// dump($_SESSION);
// $_SESSION['snow'] = 'storm';
// dump($_SESSION);
// unset($_SESSION);
// dump($_SESSION);
// $_SESSION['snow'] = 'storm';
// dump($_SESSION);

var_dump(session_id());

?>
<br/>
welcome to img.test.com!

