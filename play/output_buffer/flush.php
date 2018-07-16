<?php
require 'public.php';

/*
 * flush vs ob_flush
 * 
 * 结论：
 * @ php -ob_flush-> apache
 * @ apache -flush-> client
 */
 

header_after_ob_flush();
// 研究另一个问题，当已经有output压入apache时，还能不能编辑header？
function header_after_ob_flush() {
	// context: output_buffering=Off
	ob_start();
	echo 'and the small birds there were';
	ob_flush();
	header('Salvare: It being in the spring time');
	// Warning: Cannot modify header information - headers already sent by ...
	
	// 结论：到apache就不能修改header了
}

exit;
?>
<!--

`php.ini`中设置`implicit_flush=On`就能够自动`flush` 

-->


