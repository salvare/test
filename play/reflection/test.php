<?php

include_once 'public.php';

class Person{
	/**
	 * For the sake of demonstration, we"re setting this private
	 */
	private $_allowDynamicAttributes = false;
	
	/**
	 * type=primary_autoincrement
	 */
	protected $id = 0;
	
	/**
	 * type=varchar length=255 null
	 */
	protected $name;
	
	/**
	 * type=text null
	 */
	protected $biography;

	public function getId(){
		return $this->id;
	}

	public function setId($v){
		$this->id = $v;
	}

	public function getName(){
		return $this->name;
	}

	public function setName($v){
		$this->name = $v;
	}

	public function getBiography(){
		return $this->biography;
	}

	public function setBiography($v){
		$this->biography = $v;
	}
}

$class = new ReflectionClass('Person');//建立 Person这个类的反射类

$instance  = $class->newInstanceArgs();//相当于实例化Person 类
// dump($class);
// dump($instance);

// $properties = $class->getProperties();  
// dump($properties);exit;
// foreach($properties as $property) {  
// 	dump( $property->getName() ); // 属性名
// 	dump( $property->getDocComment() ); // 属性注释，必须是 /** */格式
// }  

// $methods = $class->getMethods(); // 函数
// // dump($methods);exit;
// foreach ($methods as $method) {
// 	dump( $method->getParameters() ); // 参数
// }

// $ec=$class->getmethod('getId'); // 执行函数
// $rs = $ec->invoke($instance);
// dump($rs);

// $reflect = new ReflectionObject($instance);
// dump($reflect);
?>

<!-- 
http://blog.csdn.net/qq_35440678/article/details/53414770
http://blog.csdn.net/hguisu/article/details/7357421
http://www.cnblogs.com/chenqionghe/p/4735753.html
-->



