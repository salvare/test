<?php
require 'public.php';
require 'head.php';

// . A && B || C // if(A){ B }else{ C }
// . A || B && C // if(A){ C }elseif(B){ C }

// ($a=1) && ($b=1) || ($c=1);
$a=0 && $b=1 || $c=1;
// $a=(0 && $b=(1 || $c=1));
($a=0 && $b=1) || $c=1;

dump($a);
dump($b);
dump($c);

// true == false == true;

?>




<?php
exit;
session_start();

class C {
	public function foo() {
		$bar = (new D)->getBar();
		$bar();
	}
}

class D {
	public function getBar() {
		return function() {
			dump($this);
		};
	}
}

$c = new C;
$c->foo();


exit;
$request = 'hello';
$pipe1 = function ($request, Closure $next) {
	dump('here is pipe1');
	$request = $request . ',pipe1'; 
	$request = $next($request);
	return $request;
};
$pipe2 = function ($request, Closure $next) {
	dump('here is pipe2');
	$request = $request . ',pipe2'; 
	$request = $next($request);
	return $request;
};
$pipes = [
	$pipe1,
	$pipe2
];
$destination = function ($request) {
	dump('here is destination');
	$request = $request . ',destination';
	return $request;
};

// $firstSlice = getInitialSlice($destination);
$firstSlice = function ($request) use ($destination)  {
	return $destination($request);
};
	
// $reduce = array_reduce($pipes, getSlice(), $firstSlice)
// $reduce1 = getSlice()($firstSlice, $pipe1)
$reduce1 = function ($request) use ($firstSlice, $pipe1) {
	$slice = function ($firstSlice, $pipe1) {
		return function ($request) use ($firstSlice, $pipe1) {
			return call_user_func($pipe1, $request, $firstSlice);
		};
	};
	return call_user_func($slice($firstSlice, $pipe1), $request);
};
// $reduce2 = getSlice()($reduce1, $pipe2)
$reduce2 = function ($request) use ($reduce1, $pipe2) {
	$slice = function ($reduce1, $pipe2) {
		return function ($request) use ($reduce1, $pipe2) {
			return call_user_func($pipe2, $request, $reduce1);
		};
	};
	return call_user_func($slice($reduce1, $pipe2), $request);
};

// $rt = $firstSlice($request);
// dump($rt, 'firstSlice');
$rt = $reduce1($request);
dump($rt, 'reduce1');
dump('===========================');
$rt = $reduce2($request);
dump($rt, 'reduce2');




exit;
dump(dirname('\\a\\b\\c'));
dump(basename('\\a\\b\\c'));
dump(class_exists('\\a\\b\\c'));
dump(__FILE__);
dump(realpath('./index.php'));

exit;
$arr = ['a', 'b', 'c', 'd'];
$arr = array_reverse($arr);
dump($arr);
$r = array_pop($arr);
$r = array_pop($arr);
$r = array_pop($arr);
$r = array_pop($arr);
// $r = array_pop($arr);
dump($r);
dump($arr);

exit;
define(A_ID, '76806');
define(MD5_KEY, 'fbfa2c505275750d131841bb8df00c9c');

$api_url = 'http://www.checar.cn/wzapi';

$params = [
	'action' => 'queryWeizhang',
	'aId' => A_ID,
	'carNo' => urlencode('皖AX892V'),
	'carType' => '02',
	'frameNo' => 'LVSFCAME8CF327022',
	'enginNo' => 'CJ48139',
];

$rt = ksort($params, SORT_STRING);
$temp = [];
foreach ($params as $key=>$val) {
	$temp[] = $key.'='.$val;
}
$temp = implode('&', $temp);
$temp .= '&'.MD5_KEY;
$temp = md5($temp);
$sign = strtoupper($temp);
// dump($sign);exit;

$params['sign'] = $sign;
// dump($params);exit;

$json = json_encode($params);
$base64 = base64_encode($json);
// $post_data = ['Base64'=>$base64];
$post_data = 'Base64='.$base64;
// dump($post_data);exit;

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $api_url);
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
$rt = curl_exec($ch);
// print($rt);
dump(json_decode($rt, true));


// 01:大型汽车，
// 02:小型汽车，
// 05:境外汽车，
// 06:外籍汽车，
// 07:两、三轮摩托车，
// 11:境外摩托车，
// 12:外籍摩托车，
// 15:挂车，
// 20:临时入境汽车，
// 21:临时入境摩托车，
// 22:临时行驶汽车，
// 23:公安警车，
// 26:香港出入境车辆，
// 27:澳门出入境车辆，

exit;
?>

<script src="http://www.test.com/public/js/jquery.js"></script>
<script src="http://www.test.com/public/js/jquery.cxselect.min.js"></script>


<div id="element_id"> 
	<select class="province"><option value="xx">xx</option></select> 
	<select class="city"><option value="yy">yy</option></select> 
</div> 

<script>

$('#element_id').cxSelect({
	url: 'http://www.test.com/data.json', // 提示：如果服务器不支持 .json 类型文件，请将文件改为 .js 文件 
	selects: ['province', 'city'],
// 	nodata: 'none'
	jsonName: 'name',
	jsonValue: 'value',
	jsonSub: 'brand'
}); 

</script>



