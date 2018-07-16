<script>
//var name = "The Window";
//var object = {
//name : "My Object",
//getNameFunc : function(){
//return function(){
//　　return this.name;
//};
//}
//};
//var some = object.anyfunc = object.getNameFunc();
//console.log( some() );
//console.log( object.anyfunc() );

//var name = "The Window";
//var object = {
//name : "My Object",
//getNameFunc : function(){
//var that = this;
//return function(){
//　　return that.name;
//};
//}
//};
//alert(object.getNameFunc()());


function f1(){
	var n=999;
	nAdd=function(){ n+=1; return n; }
	function f2(){
		console.log(n);
	}
	return f2;
}
var result=f1();
result(); // 999
console.log( nAdd() );
result(); // 1000

//http://www.ruanyifeng.com/blog/2009/08/learning_javascript_closures.html【excellent】
</script>