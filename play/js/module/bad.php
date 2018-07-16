<script>

_count = 0;
inc = function () {
	_count++
}
dec = function() {
	_count--
}
show = function() {
	console.log(_count)
}

show() 
inc()
show()
dec()
show()

</script>

<!-- 
@ 缺点：
1. "污染"了全局变量，无法保证不与其他模块发生变量名冲突
2. 而且模块成员之间看不出直接关系
-->