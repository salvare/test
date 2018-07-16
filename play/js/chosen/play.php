<?php 
require 'public.php';
require 'head.php';

// dump($_GET);
?>

<script src="<?php echo TEST_URL;?>/public/js/chosen_v1.8.1/chosen.jquery.js"></script>
<link rel="stylesheet" href="<?php echo TEST_URL;?>/public/js/chosen_v1.8.1/chosen.css">

<form action="" method="get">

<div><select id="s1" name="s1[]" class="" style="width:150px;" multiple > <!-- name="s1" -->
	<option value="a">111</option>
	<option value="b" selected>好好学习</option>
	<option value="c">hello world pretty</option>
	<option value="d" disabled>disabled</option>
</select></div>

<input type="hidden" name="foo" value="bar">
<button type="submit">提交</button>
</form>


<script>

var option = {
	disable_search: false
	,search_contains: true
}

$("#s1").chosen(option).on("change", function(event, data) {
	console.log(this)
	console.log(this.value)
	console.log($(this).val())
	console.log(data)
}).on("chosen:showing_dropdown", function() {
	console.log("chosen:showing_dropdown")
}).on("chosen:hiding_dropdown", function() {
	console.log("chosen:hiding_dropdown")
}).on("chosen:no_results", function() {
	console.log("chosen:no_results")
}).on("chosen:maxselected", function() {
	console.log("chosen:maxselected")
}).on("chosen:ready", function() {
	console.log("chosen:ready")
})

$("#s1").append("<option value=\"e\">added by js</option>").chosen().trigger("chosen:updated")

</script>

<!-- 

@ 多选
* `this.value` 和 `$(this).val()` 的值不一样
  . `this.value` 获取所有被选中的第一个option的value
  . `$(this).val()` 获取选中的所有value，格式是数组 （如：`["a", "c"]`）
* 提交表单时
  . 不妨以GET方式为例，参数如：`s1=b&s1=c&foo=bar` （正常状态的`<select>`不可能提交两个值）
  . 结果上服务器端只能获得最后一个值
* 仿照`<checkbox>`，用`name="s1[]"`
  . 完美解决

@ 参考：
* 文档： https://github.com/harvesthq/chosen
       http://www.test.com/public/js/chosen_v1.8.1/options.html
* 示例： http://www.test.com/public/js/chosen_v1.8.1/index.html
       http://www.play.com/js/chosen/index.html
-->