<script>

Counter = function() {
	this._count = 1
	this.inc = function () {
		this._count++;
	}
	this.dec = function () {
		this._count--;
	}
	this.show = function () {
		console.log(this._count);
	}
}

counter = new Counter();
counter.show();
counter.inc();
counter.show();
counter.dec();
counter.show();

counter._count = 233;
console.log(counter._count);
counter.show();

</script>

<!-- 

@ 缺点：
1. 外部可以直接修改属性 `_count`

-->