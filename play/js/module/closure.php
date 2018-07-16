<script>

counter = ( function() {
	var _count = 2;
	var inc = function () {
		_count++;
	}
	var dec = function () {
		_count--;
	}
	var show = function () {
		console.log(_count);
	}
	return {
		inc : inc,
		dec : dec,
		show : show
	}
} ) ();

counter.show();
counter.inc();
counter.show();
counter.dec();
counter.show();

counter._count = 233;
console.log(counter._count)
counter.show();

</script>

