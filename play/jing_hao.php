<?php
/*
 * 不同浏览器处理“#”行为
 * <a> <iframe> <img> ajax 
 */
include_once 'public.php';

if ( IS_POST ) {
	exit('Arrietty');
}

include_once 'head.php';
?>

<a href="#">hana</a>

<!-- <iframe src="#"></iframe> -->

<div id="container"></div>

<script>
$.post( "#", {param:'something'}, function(data){
	$("#container").html(data);
});
</script>

<!-- 

不同浏览器处理“#”行为

<a href="#">hana</a>
chrome: 产生新的history，URL后出现#号，没有发出请求
firefox: 同chrome
ie 11: 同chrome

<iframe src="#"></iframe>
chrome: 加载本页面，发出请求（第三次时被chrome阻止）
firefox: #不加载任何页面！
ie 11: 同firefox

$.post( "#", ...)
chrome: 请求本页面
firefox: 同chrome
ie 11: 不发出请求


chrome:同时请求同一个页面次数过多，会被阻止(status:canceled, 不是pending，firefox有类型情况，ie没有)？ 
<iframe src="#"></iframe>第三次，
ajax连续发起异步请求 没出现问题
pjax试验时有出现
总结：看来是一些特例，不用纠结
http://stackoverflow.com/questions/12009423/what-does-status-canceled-for-a-resource-mean-in-chrome-developer-tools 没什么帮助

-->