<?php
require 'public.php';

/*
 * @ `pack`函数把数据装入一个二进制字符串 
 * ↑ 不是说`'11010101'`这样的字符串，而是二进制存储内容为`11010101`的字符串
 * ↑ 一切数据都是 二进制格式 存储的。在输出或处理时，软件将 二进制数据 通过编码解释为 字符
 * ↑ 所谓 二进制字符串，就是普通 字符串，只是强调它的 存储内容，没有强调它的编码
 * @ 通过 设置选项，可以把“传入的数据”，作为“相应的格式”，解释为 “二进制字符串”
 */
 

// a();
// str->binary 长度不足用`NUL(0x00)`来填充
function a() {
	watch( pack( 'a*', '正' ) ); // 好像没什么意义
	watch( pack( 'a3', '正' ) ); // 3bytes
	watch( pack( 'a4', '正' ) ); // 4bytes，用`NUL`填充
	watch( pack( 'a2', '正' ) ); // 使用 `watch|var_dump`输出有异常，本节中不再使用
	print_r( pack( 'a2', '正' ) ); // 浏览器显示`��`，两个无法`utf-8`编码的字节
}


// type();
// pack的返回类型
function type() {
	var_dump( pack( 'a', 'x' ) ); // string(1) "x"
	
	print_r( unpack( 'a', pack( 'a', 'x') ) ); // x
	print_r( unpack( 'a', 'x' ) ); // x 同上
	
	// 结论： 文档中说的pack返回的“二进制字符串”类型，就是“字符串”类型
}


// do_unpack();
// binary->other 
function do_unpack() {
	
	print_r( pack( 'N', 15117731 )."\n" ); // 正。 十进制数表示是 15117731，十六进制表示是 e6ada3
	
// 	print_r( unpack( 'N', '正' ) ); // unpack(): Type N: not enough input, need 4, have 3 
	print_r( unpack( 'N', pack( 'a4', '正' ) ) ); // -424828160
	// ↑ 为什么是负数？？？
	print_r( unpack( 'N', pack( 'a4', "\0正" ) ) ); // 15117731
	// ↑ 手动扩展到32位
	print_r( unpack( 'N', "\0正" ) ); // 15117731
	print_r( unpack( 'N', "正\0" ) ); // -424828160
	var_dump( hexdec('e6ada300') );
	// ↑ 但 `"正\0"` 的十六进制表示是`e6ada300`，十进制表示是`3870139136`
	var_dump( printf( "%u", -424828160 ) ); // 3870139136
	var_dump( printf( "%d", 3870139136) ); // -424828160
	// ↑ 幸运(？)的是，printf默认了整数位为32位
	var_dump( hexdec('e6ada300')-pow(2, 32) ); // -424828160
	// ↑ `e6ada300`:原码解释为`3870139136`，补码解释为`-424828160`
	
	// ↑ PHP中 `signed -424828160` 和 `unsigned 3870139136` 的存储格式是否相同呢
	// ↓ 【important】但是PHP中有区分数据类型吗，或者默认用了哪一种，本节简单讨论
	
	print_r( pack( 'N', -424828160 )."\n" ); // 正\0
	print_r( pack( 'N', 3870139136 )."\n" ); // 正\0
	// ↑ 从这个角度看，存储结构相同
	$y = 3870139136;
	$b = -424828160;
	var_dump($b-$y);
	// 但是是拥有数据类型的，在表达式中，会根据其类型，解释为不同的含义
	
	
	print_r( unpack( 'H*', '正') ); // e6ada3
	print_r( unpack( 'h*', '正') ); // 6eda3a
	// ↑ 将 二进制字符串 解释为 16进制数格式字符串 
	print_r( bin2hex('正') ); // 效果等同
}
  

// do_chr();
// chr 有类似 pack 的功能
function do_chr() {
	print_r( chr(0x61)."\n" ); // a
	
	echo chr(0xe6);
	echo chr(0xad);
	echo chr(0xa3)."\n";
	
	$bin = "正"; // utf-8 3bytes
	echo $bin{0} ;
	echo $bin{1} ;
	echo $bin{2}."\n" ;
	
	echo pack('H2','e6');
	echo pack('H2','ad');
	echo pack('H2','a3')."\n";
}


// usage();
// 可以用来查看功能字符
function usage() {
	echo bin2hex("\r\n");
	echo bin2hex("hello
	kitty");
	exit;
}


// h();
function h() {
	// e6ada3
	echo pack('h*', '16'); // a
	echo pack('h*', '6eda3a'); // 正
	echo pack('h*', '166eda3a'); // a正
}


// c();
function c() {
	echo pack('c', '97'); // a	singed char
}
	

// n();
function n() {
	print_r( pack('n*', 97, 98)."\n" ); // \0a\0b 
	// ↑ unsigned short (16bit)
	// ↑ `*` 表示能接受多个参数
	print_r( pack('n', 15117731)."\n" ); // ��
	// ↑ utf-8汉字占3字节，16位无法表示
	print_r( pack('N', 15117731)."\n" ); // \0正
}


// nul();
// `\0`字符
function nul() {
	print_r( unpack('H*', "\0") ); // 0x00
	print_r( bin2hex("\0")."\n" ); // 0x00
}


// complex();
// 复合选项
function complex() {
	$bin = pack("a*C", "陈一回", 97);
	echo $bin."\n";
	$bin = pack("a*CN", "陈一回", 97, 15117731);
	echo $bin."\n";
	$bin = pack("a*CH*", "陈一回", 97, 'e6ada3' );
	echo $bin."\n";
}


do_unpack_again();
function do_unpack_again() {
	$bin = pack("a*CH*", "陈一回", 97, 'e6ada3' );
	print_r( unpack("a9name/Cage/H*gender", $bin) );
	//参考：https://my.oschina.net/goal/blog/195749
}


// do_iconv();
function do_iconv() {
	$str = "a b c d e \r f \n g";
	watch( $str );
	watch( iconv( 'utf-8', 'ASCII', $str ) ); // utf-8在 一字节字符 中是与 ASCII 重合的
}


exit;
?>

<!--
@ 常用选项
a - NUL-padded string
H - Hex string, high nibble first
h - Hex string, low nibble first
C - unsigned char
n - unsigned short (always 16 bit, big endian byte order)
N - unsigned long (always 32 bit, big endian byte order)
 -->