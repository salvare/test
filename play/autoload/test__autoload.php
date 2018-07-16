<?php
/*
 * 试用 `__autoload` 方法。
 * 用法上与 `spl_autoload_regisiter`所注册的方法相同
 * 
 * 即将弃用：
 * Warning: This feature has been DEPRECATED as of PHP 7.2.0. Relying on this feature is highly discouraged.
 */
use Foo\Bar\Fruit\Apple;
require 'public.php';

$apple = new Apple();
$purple = new Foo\Bar\Color\Dark\Purple();

function __autoload($class) {
	// 项目的命名空间前缀
	$prefix = 'Foo\\Bar\\';
	
	// 命名空间前缀对应的base目录
	$base_dir = __DIR__ . DIRECTORY_SEPARATOR;
	
	// 检查$class中是否包含命名空间前缀
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		// 未包含，立即返回
		return;
	}
	
	// 获取相对类名
	$relative_class = substr($class, $len);
	
	// 用base目录替代命名空间前缀,
	// 在相对类名中用目录分隔符'/'来替换命名空间分隔符'\',
	// 并在后面追加.php组成$file的绝对路径
	$file = $base_dir . str_replace('\\', DIRECTORY_SEPARATOR, $relative_class) . '.class.php';
	$filee = $base_dir . str_replace('\\', DIRECTORY_SEPARATOR, $relative_class) . '.php';
	
	if (file_exists($file)) {
		require $file;
	} elseif (file_exists($filee)) {
		require $filee;
	}
}