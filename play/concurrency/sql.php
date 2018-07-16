<?php
require 'public.php';

$record = __DIR__.'/temp';
$pdo = include LIB_PATH.'/pdo.php';

if ( $_POST['action']=='main' ) {
// 	record( date('H:i:s'), $_POST['flag'], $record );
// 	sleep(5);
// 	record( date('H:i:s'), $_POST['flag'], $record );

	$pdo->beginTransaction();
	$pdo->exec("INSERT INTO admin_menu (parent_id) VALUES (23232)");
	$rs = $pdo->query("SELECT id FROM admin_menu ORDER BY id DESC LIMIT 0,1");
	$rs2 = $pdo->query("SELECT connection_id() as id");
	$pdo->commit();
	$rs = $rs->fetchAll(PDO::FETCH_ASSOC);
	$rs2 = $rs2->fetchAll(PDO::FETCH_ASSOC);
	dump( $rs2[0]['id'], 'connect' );
	record( date('H:i:s').' '.$rs[0]['id'], $_POST['flag'], $record, true );
	dump( date('H:i:s').' '.$rs[0]['id'], $_POST['flag'] );
	
	sleep(5);
	
	$rs = $pdo->query("SELECT @@IDENTITY as id ");
	$rs = $rs->fetchAll(PDO::FETCH_ASSOC);
	record( date('H:i:s').' '.$rs[0]['id'], $_POST['flag'], $record, true );
	dump( date('H:i:s').' '.$rs[0]['id'], $_POST['flag'] );
	
	/*
	 * 期待：
	 * <1> 16:51:53 20
	 * <2> 16:51:53 21
	 * <1> 16:51:58 21
	 * <2> 16:51:58 21
	 * 实际：
	 * <1> 16:51:53 20
	 * <2> 16:51:53 21
	 * <1> 16:51:58 20
	 * <2> 16:51:58 21
	 * 结论：
	 * `@@IDENTITY`表现良好。。？？？？！
	 */
	
	exit;
}

if ( $_POST['action']=='see' ) {
	sleep(1);// 加上这个就能看出连续的几次点击每次connection_id不一样
	$rs = $pdo->query("SELECT @@IDENTITY as id ");
	$rs = $rs->fetchAll(PDO::FETCH_ASSOC);
	$rs2 = $pdo->query("SELECT connection_id() as id");
	$rs2 = $rs2->fetchAll(PDO::FETCH_ASSOC);
	record( $rs[0]['id'], 'see', $record, true );
	dump( $rs[0]['id'], 'see' );
	dump( $rs2[0]['id'], 'see' );
	exit;
}

if ( $_POST['action']=='see_connection' ) {
	$rs = $pdo->query("SELECT connection_id() as id ");
	$rs = $rs->fetchAll(PDO::FETCH_ASSOC);
	record( $rs[0]['id'], 'connection', $record, true );
	dump( $rs[0]['id'], 'connection' );
	exit;
}


include 'head.php';
?>
<button onclick="main()">main</button>
<button onclick="do_action('see')">see</button>
<button onclick="do_action('see_connection')">see connection</button>
<script>
function do_action(action) {
	$.post("",{action:action});
}

function main() {
	$.ajax({
		url : "",
		data : {action:"main",flag:1},
		type : "post",
		async : true,
	});
	$.ajax({
		url : "",
		data : {action:"main",flag:2},
		type : "post",
		async : true,
	});
}
</script>

<!-- 

似乎有这样的问题：
foreach ( $list as $key=>$val ) 
{
	//该表在插入时会用 number字段 为当天的记录排序，
	//找到前一个number
	$temp = $model->query("SELECT number FROM my_table WHERE date='2016-6-27' ORDER BY number DESC"); // action1
	$previous_number = $temp['number'];
	//加一
	$previous_number++;
	//插入新数据
	$model->execute("INSERT ...... number='$previous_number' ");//action2
}
loop2的action1在执行时，
loop1的action2虽然php代码执行完成，但是数据库的写入工作尚未完成（异步？）
从而造成错误
↑ 【2017-7-19】 是可能出错，不过是因为有可能读出`number`后，有其它进程又更新了`number`，导致取到的数值过期
	数据表对于不同会话是公共资源

还有常见操作：插入数据到主表，获取id，插入数据到子表时，也会有这个问题。
↑ 【2017-7-19】 如果用`@@IDENTITY`，是一个“会话变量”，是<u>不容易</u>不会出错的，脚本执行过程中，只要连接不释放，获取的值一定是前一个插入值


http://www.cnblogs.com/yasmi/articles/5587868.html【MySQL中的连接、实例、会话、数据库、线程之间的关系】【perfect】


@ 作用域
http://www.cnblogs.com/adandelion/archive/2010/08/25/1808244.html【SQL SERVER 会话 作用域概念】
一个作用域 就是一个模块——存储过程、触发器、函数或批处理。因此，如果两个语句处于同一个存储过程、函数或批处理中，则它们位于相同的作用域中。
mysql中可能没有作用域概念
http://bbs.csdn.net/topics/330248594【请教 sqlserver中的作用域的问题】
http://www.cnblogs.com/deymmtd/archive/2009/02/25/1397653.html【SCOPE_IDENTITY和@@identity的区别】 这篇文章中“作用域”的概念像是指一个表


http://www.studyofnet.com/news/145.html【@@IDENTITY的用法】【good】
http://www.cnblogs.com/deymmtd/archive/2009/02/25/1397653.html【SCOPE_IDENTITY和@@identity的区别】
在sqlserver中，
`@@IDENTITY`限制当前会话，不限制当前作用域； (insert t1 时 trigger insert t2， 获得的是newt2.id)
`SCOPE_IDENTITY()` 限制当前会话，且限制当前作用域； (insert t1 时 trigger insert t2， 获得的是newt1.id)
`IDENT_CURRENT()` 不受作用域和会话的限制，而受限于指定的表
↑ 那么只能用 `@@IDENTITY/last_insert_id`的mysql，遇到 trigger 怎么办？？


http://bbs.csdn.net/topics/390659372【@@identity和LAST_INSERT_ID()有什么区别么】 
完全一样


http://ask.chinaunix.net/question/841【如何获取mysql会话的ID？】
select connection_id()
navicat的每个查询窗口都有不同的connection_id
对`sleep(1);connect();`脚本的连续请求也会有不同的connection_id
但是不连续的请求（一次请求完成之后<=其实是一次连接释放之后），脚本会使用之前的connection_id
	↑ 是pdo的行为？总之是哪层导致的？
这里的CONNECTION_id 与 `CONNECT数据库（物理连接）` 是同一个含义吗，还是只是表示不同的`会话`？






-->
