<?php 
/*
 * 秘钥对的生成和使用方法
 */
require 'public.php';

//创建公钥和私钥
$config = [
	'private_key_bits' => 1024,
	'config' => 'C:\xampp\apache\conf\openssl.cnf', // window系统缺少了openssl环境变量
];
$res = openssl_pkey_new($config);
//提取私钥
openssl_pkey_export($res, $private_key, null, $config); // true
//生成公钥
$public_key=openssl_pkey_get_details($res);
$public_key=$public_key['key'];
//显示数据
dump($private_key, 'private_key');
dump($public_key, 'public_key');

//要加密的数据
$data = 'Web site:http://www.04007.cn';
dump($data, '加密的数据');
//私钥加密后的数据
openssl_private_encrypt($data,$encrypted,$private_key);
//加密后的内容通常含有特殊字符，需要base64编码转换下
$encrypted = base64_encode($encrypted);
dump($encrypted, '私钥加密后的数据');
//公钥解密
openssl_public_decrypt(base64_decode($encrypted), $decrypted, $public_key);
dump($decrypted, '公钥解密后的数据');

//公钥加密
openssl_public_encrypt($data, $encrypted, $public_key);
$encrypted = base64_encode($encrypted);
dump($encrypted, '公钥加密后的数据');
//私钥解密
openssl_private_decrypt(base64_decode($encrypted), $decrypted, $private_key);//私钥解密
dump($decrypted, '私钥解密后的数据');

?>

<!-- 

# window环境下使用PHP OpenSSL扩展函数`openssl_pkey_new()`返回false的原因 
  https://yq.aliyun.com/php/8769
  
-->


