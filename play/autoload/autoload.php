<?php

/**
 * An example of a project-specific implementation.
*
* After registering this autoload function with SPL, the following line
* would cause the function to attempt to load the \Foo\Bar\Baz\Qux class
* from /path/to/project/src/Baz/Qux.php:
*
*      new \Foo\Bar\Baz\Qux;
*
* @param string $class The fully-qualified class name.
* @return void
*/
spl_autoload_register(function ($class) {
// 	dump($class);exit;

	// project-specific namespace prefix
	// 项目的命名空间前缀
	$prefix = 'Foo\\Bar\\';

	// base directory for the namespace prefix
	// 命名空间前缀对应的base目录
// 	$base_dir = __DIR__ . '/src/';
	$base_dir = __DIR__ . DIRECTORY_SEPARATOR;

	// does the class use the namespace prefix?
	// 检查$class中是否包含命名空间前缀
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		// no, move to the next registered autoloader
		// 未包含，立即返回
		return;
	}

	// get the relative class name
	// 获取相对类名
	$relative_class = substr($class, $len);
// 	dump($relative_class);exit;

	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	// 用base目录替代命名空间前缀,
	// 在相对类名中用目录分隔符'/'来替换命名空间分隔符'\',
	// 并在后面追加.php组成$file的绝对路径
	$file = $base_dir . str_replace('\\', DIRECTORY_SEPARATOR, $relative_class) . '.class.php';
	$filee = $base_dir . str_replace('\\', DIRECTORY_SEPARATOR, $relative_class) . '.php';
// 	dump($file);exit;

	// if the file exists, require it
	// 如果文件存在，则通过require关键字包含文件
	if (file_exists($file)) {
		require $file;
	} elseif (file_exists($filee)) {
		require $filee;
	}
	
});

?>
<!-- 

将函数注册到SPL __autoload函数队列中。如果该队列中的函数尚未激活，则激活它们。

如果在你的程序中已经实现了__autoload()函数，它必须显式注册到__autoload()队列中。因为 spl_autoload_register()函数会将Zend Engine中的__autoload()函数取代为spl_autoload()或spl_autoload_call()。

如果需要多条 autoload 函数，spl_autoload_register() 满足了此类需求。 它实际上创建了 autoload 函数的队列，按定义时的顺序逐个执行。相比之下， __autoload() 只可以定义一次。

-->