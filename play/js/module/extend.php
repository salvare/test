<script>

counter = null

counter = ( function(mod) {
	mod.base = ( function(mod) {
		var inc = function () {
			mod.set(mod.get() + 1)
		}
		var dec = function () {
			mod.set(mod.get() - 1)
		}
		return {
			inc : inc,
			dec : dec,
			temp : mod
		}
	} ) (mod)
	return mod
} ) (counter || {})


counter = ( function(mod) {
	var _count = 2
	mod.show = function () {
		console.log(_count)
	}
	mod.get = function () {
		return _count;
	}
	mod.set = function (val) {
		_count = val;
	}
	return mod
} ) (counter || {});


counter = ( function(mod) {
	mod.extend = ( function () {
		var double = function () {
			mod.set(mod.get() * 2)
		}
		var decc = function () {
			mod.set(mod.get() - 2)
		}
		return {
			double : double,
			decc : decc
		}
	} ) (mod)
	return mod
} ) (counter || {});


counter.show();
counter.base.inc();
counter.show();
counter.base.dec();
counter.show();
counter.extend.double();
counter.show();
counter.extend.decc();
counter.show();

</script>

<!-- 

1. 类似oop中的“继承”思想，`counter`获得了`base`和`extend`“子模块”提供的方法
2. `counter || {}`可以使模块以任意顺序加载

-->
