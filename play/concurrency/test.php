<?php



// $fp = fopen('./lock.txt', 'r+');
// $val = fread($fp, 1024);
// dump($val);
// sleep(2);
// rewind($fp);
// fwrite($fp, $val+1);
// fclose($fp);
// exit;


$fp = fopen('./lock.txt', 'r+');
if(flock($fp,LOCK_EX))
{
	// 处理商品数据
	$val = fread($fp, 1024);
	dump($val);
	sleep(2);
	rewind($fp);
	fwrite($fp, $val+1);
	flock($fp,LOCK_UN);
}
fclose($fp);




function make_inc_num($key) {
	$date = date('Ymd');
	for( $i=0; $i<3; $i++ ) { // try 3 times
		$lock = $this->cache->setnx($key.'_lock', 1); // 加锁
		if ( $lock ) {
			$this->cache->expire($key.'_lock', 1); // 1s过期防止死锁
			$number = $this->cache->get($key.'_'.$date);
			$number || $number=0;
			$number++;
			$this->cache->set($key.'_'.$date, $number);
			$this->cache->del($key.'_lock');
			return $number;
		} else {
			usleep(100*1000); // 0.1s
		}
	}
	return false;
}
