<?php
include_once 'public.php';
include_once __DIR__.'/psr-4.php';

// instantiate the loader
$loader = new \Example\Psr4AutoloaderClass;
// register the autoloader
$loader->register();
// register the base directories for the namespace prefix
$loader->addNamespace('Foo\Bar', __DIR__);
$loader->addNamespace('Salvare\Shadow', __DIR__.'/Color/Light');
$loader->addNamespace('Salvare', __DIR__.'/Colour'); // 此时用 `Salvare\Shadow\Pink` 无法实例化 `./Colour/Shadow/pink.php` 的 `Pink` 类。因为规则首先试图匹配`Salvare\Shadow`，然后才是`Salvare`
$loader->addNamespace('Foo\Bar', __DIR__.'/Colour', true);

$apple = new Foo\Bar\Fruit\Apple();
$yellow = new Foo\Bar\Color\Light\Yellow(); // windows对文件名大小写不敏感
$pink = new Salvare\Shadow\Pink(); // `./Color/Light/pink.php`
// $yellow_again = new Salvare\Shadow\Yellow(); // error
$berry = new Foo\Bar\Shadow\Berry(); // 同一个prefix也可以映射多个path

?>

<!-- 

# 参考
- http://www.cnblogs.com/saw2012/archive/2013/01/30/2882451.html【PHP规范PSR0和PSR4的理解】
- https://www.php-fig.org/psr/psr-0/
- https://www.php-fig.org/psr/psr-4/

@ `psr-0`
. PHP5.3之前没有命名空间概念，为了使命名不重复，而使用类似`Acme_Util_Foo_Bar`这样的命名方法
. 目录结构`vendor/acme/util/foo/bar.php`，类名`class Acme_Util_Foo_bar{}`
. 自PHP5.3支持命名空间后
  . 项目的命名空间`\Acme\Util`首先会映射到`vendor/acme/util`目录 （自动加载要用）
  . 所有文件都加上命名空间，变成`namespace \Acme\Util; class Acme_Util_Foo_bar{}`
  . 但是项目代码中是这样写的`new Acme_Util_Foo_bar()`，实际上就是`new \Acme\Util\Acme_Util_Foo_bar()`，
    . 怎样才能找到文件路径`vendor/acme/util/foo/bar.php`呢？
    . 如果namespace `\Acme\Util`与 类`Acme_Util_Foo_bar`的前两节完全一致，那确实能解析出路径
    . 但如果想把命名空间改成`\Acme\Xxx`,映射到`vendor/acme/xxx`目录，就无法解析了
    . 为了使命名空间不受原类名约束，将原来的项目整体移到`vendor/acme/xxx`目录下
    . `new \Acme\Xxx\Acme_Util_Foo_bar()`将能找到文件`vendor/acme/xxx/acme/util/foo/bar.php` <= 正是`psr-0`的规范
. `psr-0`正是因此而制定出的规范
! 以上是我根据一些资料猜测的，但是很靠谱不是吗 :P
# https://laravel-china.org/topics/1002/deep-composer-autoload【深入 Composer autoload】【excellent】

-->
 
