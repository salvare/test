<?php 
// header('Content-Type: text/html; charset=gbk');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="gbk">
</head>
<body>
<h4>你好</h4>
<h4>happytree</h4>
</body>
</html>

<!-- 

`php.ini`中默认设置 `default_charset="UTF-8"`
此时，服务器会自动添加header `Content-Type: text/html; charset=utf-8`
`<meta charset="gbk">` 将无效
可以设置 `php.ini`为 `default_charset=`

-->