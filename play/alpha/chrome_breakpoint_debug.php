<b onclick="f4();">SLEEP</b>
<script>

function f1(x) {
	console.log('f1');
}

function f2(x) {
	f1({'happy':'tree'});
	console.log('f2');
	console.log('f2.1');
	console.log('f2.2');
	f1();
}

function f3(x) {
	console.log('f3');
	f2([1,2,3]);
}

function f4() {
	console.log('f4');
	f3(1);
}

</script>