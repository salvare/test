<?php
require 'public.php';

/*
 * 直接 动态 的将数据作为文件内容上传
 * 一般我们会将内容写入临时文件（如：php://temp）再删除掉，
 * 这里用的是另一个方法（但不推荐使用，看正文可知）
 * 
 * 参考：http://blog.csdn.net/zhangquanit/article/details/52472675 【good 列出了multipart/form-data的报文格式】
 */

$mimetype = 'text/plain';
$postname = 'attachment_upload';//上传后的文件的文件名

$key = "foobar\"; filename=\"$postname\"\r\nContent-Type: $mimetype\r\n"; 
/*
============key格式如下============
foobar"; filename="attachement_upload"
Content-Type: text/plain

============multipart/form-data格式的报文 文件项============
------WebKitFormBoundarykALcKBgBaI9xA79y  
Content-Disposition: form-data; name="foobar"; filename="file.txt"  
Content-Type: text/plain  
  
文件中的内容     
============multipart/form-data格式的报文 一般数据项============
------WebKitFormBoundarykALcKBgBaI9xA79y  
Content-Disposition: form-data; name="username"  
  
zhangsan  
============原理============
利用curl原本写入一般数据`name=>value`的方法，
强行将`name`改成上述`key`，使得curl构造报文时恰巧构成 文件项 的格式
尽管如此，拼凑得的内容 比起 标准格式 依然会有些相差（但接收方依然可以识别，不致错）。
不推荐使用这种方法
*/
watch($key,'key');
$data = array($key=>"a victory hide in a simple soul."); 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, DOMAIN.'/curl/server.php?from=upload' );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$content = curl_exec($ch);
