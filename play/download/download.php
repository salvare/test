<?php
require 'public.php';

/*
 * @ 下载文件（动态内容）
 * @ 实现断点续传功能，客户端代码见 `play/curl/curl/download_break.php`
 * @ 已收录入function.php
 */

// watch($_SERVER);
// set_time_limit(10);

$file_path = RES_PATH.'/demo.mkv';
$speed = 512; // 下载最大速度，单位kb

$pos = strrpos($file_path, "/");
$file_name = substr($file_path, $pos+1);
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
// 	echo fread($fh, round($speed*1024, 0)); 
	$read_length = $speed*1024<$content_length ? $speed*1024 : $content_length; // 如有有Range参数，准确响应 指定的内容
	$content_length -= $read_length;
	echo fread($fh, $read_length);
	ob_flush();
	sleep(1);
}
($fh != null) && fclose($fh);

/** $file_size  文件大小 */
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

exit;
?>
