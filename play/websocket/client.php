<?php

?>

<script>
var ws = new WebSocket("ws://localhost:10032");
ws.onopen = function(){
    console.log("shakehand success");
};
ws.onmessage = function(e){
    console.log("message:" + e.data);
};
ws.onclose = function(evt) {
	console.log("connection closed.");
};   
ws.onerror = function(){
    console.log("error");
};   
</script>