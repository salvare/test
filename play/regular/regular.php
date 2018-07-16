<?php
header("content-type:text/html;charset=utf8");
include_once '../common/DatabaseHandle.php';
$db = new DatabaseHandle();

/*
 * ----------------- FOR MYSQL ---------------------------------------
 */
// $reg = '\n';//经典的例子，转义，单引号，双引号，正则
// $reg = "\n";
// $sql1 = "SELECT id,url FROM admin_nav WHERE url REGEXP 
// 'hhh' ";
// $sql2 = "SELECT id,url FROM admin_nav WHERE url REGEXP \n		'hhh' ";

// $reg = "\^";
// $reg = "\\^";
// $reg = "\\\^";
// $reg = "\\\\^";

// $reg = "\";
// $reg = "\\";
// $reg = "\\\\";
// $reg = "\\\\\\";
// $reg = "\\\\\\\\";  //！！！correct

// $reg = "[\\]";
// $reg = "[\\\\]";  //！！！correct
// $reg = "[\\\\\\\\]";  //当然也是对的  像[aa]一样

// $reg = "[^]";  //mysql发生语法错误
// $reg = "[\\^]";  //同上
// $reg = "[s^]";  //^并不需要转义,但在[]内最前是取反的意思,且单独的^语法错误

// $reg = "\a";  //mysql中 不存在 这么个转义字符  结果是匹配 a
// $reg = "\b";  //mysql中 存在 这么个转义字符  结果是匹配 (\b)


// $reg = "dream|kitty";
// $reg = "^index";
// $reg = "index$";
// $reg = ".";
// $reg = "0+";
// $reg = "0{2}";
// $reg = "0{1,3}";
// $reg = "[bj]";
// $reg = "^[^b-z0-9]*$";

// $reg = '^[^n]*$';
// $reg = "[*]{2}";
// $reg = "[\n]{2}";
// $reg = '[\n]{2}';
// $reg = '[\\\\]{2}';
// $reg = '[\]{2}';
// $reg = "\n";
// $reg = "^[[:alpha:]]+$";  //英文字母
// $reg = "^[[:lower:]]+$";  //小写英文字母
// $reg = "^[[:upper:]]+$";  //大写英文字母
// $reg = "^[[:digit:]]+$";  //数字
// $reg = "^[[:alnum:]]+$";  //英文字母 和 数字
// $reg = "^.*[[:blank:]]+.*$";  //space 和 tab
// $reg = "[[:<:]]world[[:>:]]";

// $reg = "^[0-9A-Z]+@[0-9a-z]+.com$";

// var_dump($reg);
// $sql = "SELECT id,url FROM admin_nav WHERE url REGEXP '$reg' ";
// var_dump($sql);

// $result = $db->selectData($sql);
// print_r($result);


/*
 * ----------------- FOR PHP ---------------------------------------
 */

$list = $db->selectData("SELECT id,url FROM admin_nav");


// $reg = "/\\/";
// $reg = "/\\\\/";  // correct!

// $reg = "/\n/";
// $reg = '/\n/';

// $reg = "/world$/";
// $reg = "/^world/";
// $reg = "/world/";
// $reg = "/world\B/";
// $reg = "/\Bworld/";
// $reg = "/\bworld\b/";

// $reg = "/^[\w]+$/";
// $reg = "/^[\W]+$/";
// $reg = "/^[\d]+$/";
// $reg = "/^[\s]+$/";
// $reg = "/^[\S]+$/";
// $reg = "/^[A-Z]+$/";
// $reg = "/^[a-z]+$/";
// $reg = "/lily|hello/";

// $reg = "|<[^>]+>.*</[^>]+>|U";
// $reg = "|<[^>]+>(.*)</[^>]+>|U";//最后面的 |U 表示只匹配最近的一个字符串;不重复匹配;即 .* 本来是贪婪模式匹配,会尽量匹配最多的字符串,后面有|U则变为非贪婪模式,只匹配最少的字符串 

// $reg = "|<([^>]+)>(.*)</\1>|";//error

// $reg = "/^[\w]+$/";

// var_dump($reg);
// foreach($list as $key=>$val){
// 	if( !preg_match_all($reg,$val['url'],$out, PREG_SET_ORDER) ){//SET PATTERN
// 		unset($list[$key]);
// 	}else{
// 		//print_r($out);
// 	}
// }
// print_r($list);

?>

<!-- ----------------- FOR JavaScript --------------------------------------- -->
<script type="text/javascript">
// var str = "http://www.bilibili.com"; 
var str = "-_/  ";

// var regx = "/a(b)c/";  //string
// var regx = /u(s)er/g;  //object

// var regx_str = "^[-_/\\s]+$";
// var regx = new RegExp(regx_str);

var regx = /^[-_/\\s]/;

// var rs=regx.exec(str);
var rs=regx.test(str);
console.log(regx);
console.log(rs);
</script>

