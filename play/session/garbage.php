<?php
require 'public.php';

/*
 * session 垃圾回收
 * @ context: gc_probability=1; gc_divisor=1; gc_maxlifetime=60; save_handler=files; save_path="C:\xampp\tmp"
 */

// 仅session_start，没有读写
if ( isset( $_GET['nothing'] ) ) {
	session_start();
	exit;
}
if ( isset( $_GET['read'] ) ) {
	session_start();
	dump($_SESSION);
	exit;
}

session_start(); 
$_SESSION['sid'] = session_id();
$_SESSION['time'] = date('H:i:s');
dump($_SESSION);

/*
 * @ test1: 打开3个浏览器：C1,C2,C3，访问该页面
 *   结果：`session.save_path`路径下，出现 `sess_xxxx`格式的文件，其中`xxxx`是`PHPSESSID`cookie的值
 * @ test2: 60s后用C1再次访问该页面
 *   结果：C2,C3对应的文件被回收（删除）了。C1文件依然存在，而且`change time`不变，`access time`不变，`modified time`刷新
 * @ test3: 60s后用C1访问 xxx?nothing
 *   结果：依然只有`modified time`被刷新（尽管实际没有修改内容）
 *   猜想：是不是说明实际上在读内存？？？
 * @ test4: 验证test3。重启apache，此时应会释放内存，然后用C1访问 xxx?nothing，再访问 xxx?read
 *   结果：依然只有`modified time`被刷新，`access time`依然没有刷新！？？
 *   ↑ http://blog.csdn.net/ayu_ag/article/details/51123198
 *   ↑ http://blog.csdn.net/wodeqingtian1234/article/details/53975744
 *   总之别较真了...
 */

exit;
?>
<!--

@ session垃圾回收(garbage collection)机制
* 三个参数配置了gc机制：
  . session.gc_probability=1
  . session.gc_divisor=1000
  . session.gc_maxlifetime=1440
* 含义：
  . gc_maxlifetime: 规定了某个session的“保障”生存时间
    ` 此处 session 是指某个会话的session，而不是$_SESSION数组中的某项
    ` 此处“保障”是指即使达到gc_maxlifetime，也不一定会被回收，只是存在被回收的可能性(见下)
    ` 此处 生存时间 是指 session 的 `last access time` (一说是`last modified time`) 距当前时刻 的时间
  . `gc_probability` 和 `gc_divisor` 决定了 gc 触发概率： 1/1000
  . 每当发生一次（开启会话的）请求时，都有上述概率触发gc，一旦触发，会清除当前所有过期的session
# 参考：http://www.cnblogs.com/wenphp/p/4871500.html【session垃圾回收机制】

 -->
 
 