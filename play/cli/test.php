<?php  
/** A example denoted muti-process application in php 
 * @filename fork.php 
 * @touch date Wed 10 Jun 2009 10:25:51 PM CST 
 * @author Laruence<laruence@baidu.com> 
 * @license http://www.zend.com/license/3_0.txt   PHP License 3.0 
 * @version 1.0.0 
*/  
   
/** 确保这个函数只能运行在SHELL中 */  
if (substr(php_sapi_name(), 0, 3) !== 'cli') {  
    die("This Programe can only be run in CLI mode");  
}  
   
/**  关闭最大执行时间限制, 在CLI模式下, 这个语句其实不必要 */  
set_time_limit(0);  
   
// $pid  = posix_getpid(); //取得主进程ID  
// $user = posix_getlogin(); //取得用户名  
// posix不支持windows https://segmentfault.com/q/1010000003876526
// http://php.net/manual/en/refs.utilspec.cmdline.php

echo "
USAGE: [command | expression]  
input php code to execute by fork a new process  
input quit to exit  
   
        Shell Executor version 1.0.0 by laruence  
";
   
while (true) {  
   
        $prompt = "\nhello$ ";  
        $input  = readline($prompt);  
   
        readline_add_history($input);  
        if ($input == 'quit') {  
               break;  
          }  
        process_execute($input . ';');  
}  
   
exit(0);  
   
function process_execute($input) {  
        $pid = pcntl_fork(); //创建子进程  
        if ($pid == 0) {//子进程  
                $pid = posix_getpid();  
                echo "* Process {$pid} was created, and Executed:\n\n";  
                eval($input); //解析命令  
                exit;  
        } else {//主进程  
                $pid = pcntl_wait($status, WUNTRACED); //取得子进程结束状态  
                if (pcntl_wifexited($status)) {  
                        echo "\n\n* Sub process: {$pid} exited with {$status}";  
                }  
        }  
}  