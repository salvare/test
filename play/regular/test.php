<?php
include 'public.php';

// $r = explode('','abacad');
// $r = preg_split('//', "abacad");
// $r = preg_split('/(?<!^)(?!$)/u', "abacad"); // 不匹配首尾位置
// $r = preg_split('/a/', "abacad");
// $r = preg_grep('/(?<!^)(?!$)/', ["abcd"]);
// $r = preg_grep('/(b)/', ["abcd"]);
// $r = preg_match('/.*(b).*/', "abcbd", $match, PREG_OFFSET_CAPTURE); // 匹配到的是第二个`b`，贪婪模式下第一个`.*`匹配尽可能多的内容
// $r = preg_match('/(?<!^)(?!$)/u', "abcd", $match);
// $r = preg_match_all('/a(?!$)/', "abacad", $match);
// $r = preg_match_all('/a(?=b)/', "abacad", $match);
// $r = preg_match_all('/(?<=c)a.*/', "abacad", $match);
// $r = preg_match_all('/.*(a).*/', "abacad", $match);
// $r = preg_match_all('/(a).*(c)/', "abacad", $match);

// 匹配`home/...`或`home`
$str = 'hello'; // ×
// $str = 'home'; // √
// $str = 'home/'; // √
// $str = 'home/a/b'; // √
// $str = 'eehome/a/b'; // √
// $str = 'homework'; // ×
// $str = 'homework/a'; // ×
// $reg = '/^home/';
// $reg = '/^home\//';
// $reg = '/^home[\/|$]/'; // `$`在这里不能表达行尾的意思，只是普通字符
// $reg = '/^home(\/.*)?$/'; // √
// 除了`home` => 拆解成 除了以`home`开头的 或 以`home`开头且后面还有其它内容
$reg = '/^((?!home).*|home.+)$/'; // √
// 除了`home`和`home/...`
// $reg = '/^(?!home(\/.*)?).*$/'; // 反向断言内容必须固定长度？正向断言不用
// $reg = '/^(?!home\/).*$/'; // 还要去除'home'
// $reg = '/((?=home).)*/'; // 不包含home
$reg = '/^((?!home).*|home[^\/]+.*)$/'; // √

$r = preg_match_all($reg, $str, $match, PREG_OFFSET_CAPTURE);
dump($r);
dump($match);
exit;

// 案例
preg_match_all( '/(.(?=home))*/', 'eehome/a/b', $match, PREG_OFFSET_CAPTURE);
preg_match_all('/^(.(?=home))*/', 'eehome/a/b', $match, PREG_OFFSET_CAPTURE);
preg_match_all( '/(.(?=home))+/', 'eehome/a/b', $match, PREG_OFFSET_CAPTURE);
preg_match_all( '/((?=home).)*/', 'eehome/a/b', $match, PREG_OFFSET_CAPTURE); // 很奇特，但是是能解释的

// 不包含某字符串
$str = 'except';
$str = 'hello';
$str = 'exce';
// $str = 'exceptt';
$str = 'excexcept'; 
$reg = '/^((?!except).)+$/';
$r = preg_match_all($reg, $str, $match, PREG_OFFSET_CAPTURE);
