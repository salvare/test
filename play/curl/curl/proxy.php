<?php
require 'public.php';

/*
 * proxy
 */

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'www.baidu.com');
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
// curl_setopt($ch, CURLOPT_PROXY, 'proxy.lxvoip.com:1080');
curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1"); //代理服务器地址
// curl_setopt($ch, CURLOPT_PROXY, 'script.test.com');
curl_setopt($ch, CURLOPT_PROXYPORT, 80); //代理服务器端口
// curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'user:password');
// curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC); //代理认证模式
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); //使用http代理模式

$data = curl_exec($ch);
curl_close($ch);
exit;

?>
<!-- 

试验失败

选项：
CURLOPT_HTTPPROXYTUNNEL	// 启用时会通过HTTP代理来传输
CURLOPT_PROXYUSERPWD	// 传递一个形如[username]:[password]格式的字符串去连接HTTP代理
CURLOPT_PROXYAUTH		// The HTTP authentication method(s) to use for the proxy connection. only CURLAUTH_BASIC and CURLAUTH_NTLM are currently supported.
CURLOPT_PROXY			// 设置通过的HTTP代理服务器，域名或IP?
CURLOPT_PROXYPORT		
CURLOPT_PROXYTYPE		// Either CURLPROXY_HTTP (default) or CURLPROXY_SOCKS5. 

http://chenall.net/post/php_http_proxy/【使用PHP+CURL搭建一个简易的HTTP代理服务端】【important】【附github链接】
http://blog.csdn.net/jallin2001/article/details/6599052/【例3】
http://blog.csdn.net/kobejayandy/article/details/24606521【HTTP代理协议 HTTP/1.1的CONNECT方法】【有些奇怪，好像不是我的情景】

https://www.zhihu.com/question/25143289【VPN和代理服务器的区别？ 知乎】【good】
http://blog.csdn.net/map_lixiupeng/article/details/41695045【Proxy、SSH 和VPN 的区别】

http://blog.csdn.net/clh604/article/details/9235597【HTTP代理与SOCKS代理有什么区别?】
http://blog.csdn.net/esinzhong/article/details/7265164【SOCK/HTTP代理协议解析】


 -->