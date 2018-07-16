/*
 * 公共js
 */ 

function separator_line(tag) {
	var line = "";
	if ( tag ) {
		line = "-----"+tag+"--------------\n\n\n";
		line.substr(0,20);
	} else {
		line = "--------------------\n\n\n";
	}
	console.log( line );
}

// cookie 
function setCookie(name,value) 
{
    var Days = 30; 
    var exp = new Date(); 
    exp.setTime(exp.getTime() + Days*24*60*60*1000); 
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString(); 
}
function getCookie(name) 
{ 
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
        return unescape(arr[2]); 
    else 
        return null; 
} 
function delCookie(name) 
{ 
    var exp = new Date(); 
    exp.setTime(exp.getTime() - 1); 
    var cval=getCookie(name); 
    if(cval!=null) 
        document.cookie= name + "="+cval+";expires="+exp.toGMTString(); 
}
function clearCookie()
{
	var cookies= document.cookie.split(";");
	for ( var i in cookies ) {
		var cookie = $.trim(cookies[i]);
		var cookie_parsed = cookie.split("=");
		delCookie(cookie_parsed[0]);
	}
}