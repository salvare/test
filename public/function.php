<?php

function hello() {
	echo 'hello';
}

/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 */
// function dump($var, $label=null, $echo=true, $strict=true) {
//     $label = ($label === null) ? '' : '&lt;'.rtrim($label).'&gt;&nbsp;';
//     if (!$strict) {
//         if (ini_get('html_errors')) {
//             $output = print_r($var, true);
//             $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
//         } else {
//             $output = $label . print_r($var, true);
//         }
//     } else {
//         ob_start();
//         var_dump($var);
//         $output = ob_get_clean();
//         if (!extension_loaded('xdebug')) {
//             $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
//             $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
//         }
//     }
//     if ($echo) {
//         echo($output);
//         return null;
//     }else
//         return $output;
// }

function dump($var, $label = null, $echo = true, $flags = ENT_SUBSTITUTE)
{
	if ($var instanceof Closure) {
		return closure_dump($var);
	}
	
	$label = (null === $label) ? '' : rtrim($label) . ':';
	ob_start();
	var_dump($var);
	$output = ob_get_clean();
	$output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
	if (IS_CLI) {
		$output = PHP_EOL . $label . $output . PHP_EOL;
	} else {
		if (!extension_loaded('xdebug')) {
			$output = htmlspecialchars($output, $flags);
		}
		$output = '<pre>' . $label . $output . '</pre>';
	}
	if ($echo) {
		echo($output);
		return;
	} else {
		return $output;
	}
}

function closure_dump($closure) {
	try {
		$func = new ReflectionFunction($closure);
	} catch (ReflectionException $e) {
		echo $e->getMessage();
		return;
	}

	$start = $func->getStartLine() - 1;

	$end =  $func->getEndLine() - 1;

	$filename = $func->getFileName();

	echo implode("", array_slice(file($filename),$start, $end - $start + 1));
}

/*
 * 调试打印函数 纯文本
 */
function watch($content, $tag=null) {
	if ( $tag!==null ) {
		echo "[$tag] ";
	}
	if ( is_array($content) || is_object($content) )  {
		print_r($content);
		echo "\n";
	} else {
		var_dump($content);
		echo "\n";
	}
}

/*
 * 调试打印函数 写入文件
 * 
 * @param $instant 即时模式。如果开启，每次调用record，都会重新打开和关闭文件，即时写入
 */
function record($content, $tag=null, $file_name=null, $instant=false) {
	if ( !$instant ) {
		if ( !$file_name ) {
			if ( $GLOBALS['salvare_record']['default'] ) {
				$handle = &$GLOBALS['salvare_record']['default'];
				if ( !is_resource($handle) ) {
					$handle = fopen( $handle, 'a+' );
				}
			} else {
				return false;
			}
		} else {
			$handle = &$GLOBALS['salvare_record'][$file_name];
			if ( !$handle ) {
				$handle = fopen( $file_name, 'a+' );
			}
		}
	} else {
		$file_name || $file_name=$GLOBALS['salvare_record']['default'];
		$handle = fopen( $file_name, 'a+' );
	}
	
	$tag!==null && $tag="<$tag> ";
	fwrite($handle, $tag.$content."\r\n");
	$instant && fclose($handle);
}


/**
 * 将字符串转换成二进制
 * @param type $str
 * @return type
 */
function str2hex($str) {
	$arr = preg_split('/(?<!^)(?!$)/u', $str);
	foreach($arr as &$v){
		$temp = unpack('H*', $v);
// 		$v = base_convert($temp[1], 16, 2);
// 		unset($temp);
		$v = $temp[1];
	}

	return join(' ',$arr);
}


/**
 * 讲二进制转换成字符串
 * @param type $str
 * @return type
 */
function BinToHex($str){
	$arr = explode(' ', $str);
	foreach($arr as &$v){
		$v = pack("H".strlen(base_convert($v, 2, 16)), base_convert($v, 2, 16));
	}

	return join('', $arr);
}


/*
 * 下载文件
 */
function download($file_path, $speed=null, $file_name=null) {
	if ( !$speed || !is_numeric($speed) ) {
		$speed = 2*1024; // 默认限速2M/s
	}
	if ( !$file_name ) {
		$pos = strrpos($file_path, "/");
		$file_name = substr($file_path, $pos+1);
	}
	$file_size = filesize($file_path);
	$ranges = getRange($file_size);
	// watch($ranges);
	
	$fh =  fopen($file_path, "rb");
	header('Cache-control: public');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.$file_name);
	if ($ranges != null) {
		$content_length = $ranges['end']-$ranges['start']+1;
		header('HTTP/1.1 206 Partial Content');
		header('Accept-Ranges: bytes');
		header(sprintf('Content-Length: %u', $content_length)); // 好像设置无效，总是显示真实的报文长度
		header(sprintf('Content-Range: bytes %s-%s/%s', $ranges['start'], $ranges['end'], $file_size));
		fseek($fh, sprintf('%u',$ranges['start']));
	}else{
		$content_length = $file_size;
		header("HTTP/1.1 200 OK");
		header(sprintf('Content-Length: %s', $content_length));
	}
	
	while(!feof($fh) && $content_length>0)
	{
// 		$temp = ROOT_PATH.'/play/download/temp';record( date('H:i:s'), null, $temp, true); // fake_flag
		$read_length = $speed*1024<$content_length ? $speed*1024 : $content_length; // 如有有Range参数，准确响应 指定的内容
		$content_length -= $read_length;
		echo fread($fh, $read_length);
		ob_flush();
		sleep(1);
	}
	($fh != null) && fclose($fh);
}
function getRange($file_size){
	$range = isset($_SERVER['HTTP_RANGE'])?$_SERVER['HTTP_RANGE']:null;
	if(!empty($range)){
		$range = preg_replace('/[\s|,].*/', '', $range);
		$range = explode('-',substr($range,6));
		if (count($range) < 2 ) {
			$range[1] = $file_size;
		}
		$range = array_combine(array('start','end'),$range);
		if (empty($range['start'])) {
			$range['start'] = 0;
		}
		if (!isset ($range['end']) || empty($range['end'])) {
			$range['end'] = $file_size;
		}
		return $range;
	}
	return null;
}



// 缓存
function cache_server(){
	static $CS = null;
	if ($CS === null) {
		switch (CACHE_SERVER) {
			case 'memcached':
				$CS = new MemcacheServer(array(
				'host' => CACHE_HOST,
				'port' => CACHE_PORT,
				));
				break;
			case 'redis':
				$CS = new RedisServer(array(
				'host'  => CACHE_HOST,
				'port'  => CACHE_PORT,
				));
				break;
			default:
				$CS = new PhpCacheServer;
				$CS->set_cache_dir(TEMP_PATH . 'caches');
				break;
		}
	}
	return $CS;
}

// 解析xml
function xmlToArray($xml) {
	libxml_disable_entity_loader(true);
	$xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
	$arr = json_decode(json_encode($xmlstring),true);
	return $arr;
}
