<?php

require 'public.php';

/*
 * 实现`ArrayAccess`接口后，就可以想数组一样，用索引的方式操作对象的属性
 * 支持 读取 删除 修改 添加
 */

class H implements ArrayAccess {
	private $container = array();

	public function __construct() {
		$this->container = array(
			"one"   => 1,
			"two"   => 2,
			"three" => 3,
		);
	}

	public function offsetSet($offset, $value) {
		if (is_null($offset)) {
			$this->container[] = $value;
		} else {
			$this->container[$offset] = $value;
		}
	}

	public function offsetExists($offset) {
		return isset($this->container[$offset]);
	}

	public function offsetUnset($offset) {
		unset($this->container[$offset]);
	}

	public function offsetGet($offset) {
		return isset($this->container[$offset]) ? $this->container[$offset] : null;
	}
}

$obj = new H();

// 读
dump( isset($obj["two"]) ); // true
dump( $obj["two"] ); // 2

// 删
unset( $obj["two"] );
dump( isset($obj["two"]) ); // false

// 改
$obj["two"] = "222";
dump( $obj["two"] ); // 222

// 增
$obj["four"] = '444'; 
dump($obj);

