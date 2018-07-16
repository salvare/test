<?php

$handle = fopen('thinkphp.txt','r');

//在读取的过程中，$handle的指针随着变化
// $content = fread($handle, 100);
// echo $content;
// $content = fread($handle, 100);
// echo $content;

//优化为
// while( $content=fread($handle, 128) )
// {
// 	echo $content;
// }

//feof() 和 fgets()
// while( !feof($handle) ) //检测是否已到达文件末尾 (eof)
// {
// 	echo fgets($handle); //读取文件内容的一行
// }

// file()
$my_file = file('thinkphp.txt'); //读取全文，并按行组成数组 （包括了换行符）
foreach ($my_file as $line=>$content)
{
	echo "Line{$line}: {$content}<br/>";
}

//readfile('filename')
// $result = readfile('thinkphp.txt'); //读取全文 并 直接写入到输出缓冲(output-buffering)
// var_dump($result);

//file_get_contents
// $content = file_get_contents('thinkphp.txt'); //读取全文（不会自动输出）
// print_r($content);

// http://blog.csdn.net/xiaowall/article/details/7872503


// readfile('http://www.baidu.com/');
// echo file_get_contents('http://www.baidu.com');

// $handle = fopen('http://www.baidu.com','r');
// while( $content=fread($handle, 128) )
// {
// 	echo $content;
// }
