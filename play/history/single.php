<?php
/*
 * 尝试一个 single page application
 */
include_once 'public.php';
if ( IS_POST ) {
	$index = isset( $_POST['index'] ) ? $_POST['index'] : 0;
// 	$index = $index % 3 + 1; // next
// 	$index==0 && $scene='space';
	$index==1 && $scene='rainbow';
	$index==2 && $scene='thunder';
	$index==3 && $scene='waterfall';
	echo json_encode( ['index'=>$index,'scene'=>$scene] );
	exit;
}

include_once 'head.php';
?>

<div>
	<button id="next">=></button>
</div>
<div id="scene">space</div>
<input type="hidden" id="index" value="0"/>


<script>
$("#next").on( "click", function(){
	var index = $("#index").val();
	var next = index % 3 + 1;
	$.post( "", {'index':next}, function(data){
		update_content(data);
// 		location.hash=data.scene; // 虽然产生了 history，但是js产生的数据变化不能恢复
		var href = get_href(data.scene);
// 		location.href = href // 同上
		history.pushState( data, "", href );
	}, 'json');
});

window.onhashchange = function() {
	console.log("onhashchange");
// 	update_content(history.state); // 取用历史数据 或
	$.post( "", {'index':history.state.index}, function(data){ // 重新请求数据
		update_content(data);
		var href = get_href(data.scene);
		history.replaceState( data, "", href); // 更新历史数据。。这个例子其实没必要啦
	}, 'json');
}

function update_content(data) {
	$("#index").val(data.index);
	$("#scene").html(data.scene);
}

function get_href(anchor) {
	return "<?php echo URL;?>" + "#" + anchor;
}

</script>

