<?php
require 'public.php';

/*
 * global全局变量 机制
 * 
 * @ 参考：
 * http://www.jb51.net/article/29584.htm
 */


// 全局环境
if ( false ) {
	
$a = 1;
watch($a, '1');//1
watch($GLOBALS['a'], '1');//1

$GLOBALS['a'] = 2;
watch($a, '1.2');//1
watch($GLOBALS['a'], '1.2');//1

unset($a);
// unset($GLOBALS['a']);
watch($a, '2');//1
watch($GLOBALS['a'], '2');//1

exit;
/*
 * @结果： 对`$a`和`$GLOBALS['a']`的所有操作（包括unset），都相同的作用在对方上
 * @结论： 并不是`引用`机制，`引用`唯独`unset`会造成不同结果
 */ 
}

// reference();
function reference() {
	$a = 1;
	$b = &$a;
	watch($a);
	watch($b);
// 	unset($a);
	unset($b);
	watch($a);
	watch($b);
	exit;
}


// 局部环境
function local()
{
    global $a;

    watch($a, '1'); // 1
    watch($GLOBALS['a'], '1'); // 1

    $a = 2;
    watch($a, '2'); // 2
    watch($GLOBALS['a'], '2'); // 2

// 	unset($a); // 不影响$GLOBALS['a']的值，但是`$a`被删除，而且不再是global了
// 	watch($a, '3'); // NULL
// 	watch($GLOBALS['a'], '3'); // 2

	unset($GLOBALS['a']); // `$a`值不变，但同样不再是global了
	watch($a, '3.2'); // 2
	watch($GLOBALS['a'], '3.2'); // NULL

// 	$a = 3; // 只设置了 $a
	$GLOBALS['a'] = 3; // 无效
    watch($a, '4');
    watch($GLOBALS['a'], '4');
}
// $a = 1;
// local();
// watch($a, '5');
// watch($GLOBALS['a'], '5');
/*
 * @结果
 * 1. 赋值操作依然相同的作用于两者上，但是`unset`不一样了
 * 2. `unset($a)` 
 * 		. `$a`自身失去了`global`属性
 * 		. 不影响$GLOBALS['a']，不影响全局变量
 * 3. `unset($GLOBALS['a'])`
 * 		. 不影响`$a`的值，但是失去了`global`属性
 * 		. $GLOBALS['a'] 全局变量被删除
 */

exit;
?>