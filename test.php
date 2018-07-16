<?php
require 'public.php';
require 'head.php';



// $request = 'hello';
// $destination = function ($request) {
// 	dump('here is destination');
// 	return $request.',destination';
// };
// $m1 = function ($request, Closure $next) {
// 	dump('here is m1');
// 	$request = $request . ',m1';
// 	$request = $next($request);
// 	return $request;
// };
// $m2 = function ($request, Closure $next) {
// 	dump('here is m2');
// 	$request = $request . ',m2';
// 	$request = $next($request);
// 	return $request;
// };
// $pipes = [
// 	$m1,
// 	$m2,
// ];
// $pipes = array_reverse($pipes);

// $firstSlice = getInitialSlice($destination);

// $res = call_user_func(
// 	array_reduce($pipes, getSlice(), $firstSlice), $request
// );
// dump($res, 'res');

function getInitialSlice(Closure $destination)
{
	return function ($passable) use ($destination) {
		return call_user_func($destination, $passable);
	};
}

function getSlice()
{
    return function ($stack, $pipe) {
        return function ($passable) use ($stack, $pipe) {
            $slice = parent_getSlice();
            return call_user_func($slice($stack, $pipe), $passable);
        };
    };
}

function parent_getSlice()
{
	return function ($stack, $pipe) {
		return function ($passable) use ($stack, $pipe) {
			return call_user_func($pipe, $passable, $stack);
		};
	};
}


exit;
function sayGoodbye()
{
	return 'goodbye111!';
}
// function saygoodbye()
// {
// 	return 'goodbye222!';
// }
echo saygoOdbye();

exit;
dump(0=='a');
dump((int)'a');
dump((int)'233');
dump((int)'233a');
dump((int)'a233');

exit;
dump(scandir('.'));

exit;
class H {
	
	public function __invoke() {
		dump('__invoke');
	}
	
}

$h = new H;
$h();

exit;
?>
<script type="text/javascript" src="./test.js"></script>
<?php
exit;
$a=1;$b=2;$c=3;$d=4;
echo $a<$b?'xx':$a<$c?'yy':$a<$d?'zz':'oo';
echo (($a<$b?'xx':$a<$c)?'yy':$a<$d)?'zz':'oo';
echo $a<$b?'xx':($a<$c?'yy':($a<$d?'zz':'oo'));
exit;

if (false !== $pos = strrpos('a\\b\\c', '\\')) {
	
}
dump($pos);

exit;

dump( decbin(E_ERROR), 'E_ERROR' );
dump( decbin(E_WARNING), 'E_WARNING' );
dump( decbin(E_PARSE), 'E_PARSE' );
dump( decbin(E_NOTICE), 'E_NOTICE' );
dump( decbin(E_USER_ERROR), 'E_USER_ERROR' );
dump( decbin(E_USER_WARNING), 'E_USER_WARNING' );
dump( decbin(E_USER_NOTICE), 'E_USER_NOTICE' );
dump( decbin(E_ALL), 'E_ALL' );

dump( decbin(E_ALL^E_NOTICE), 'E_ALL' );
exit;


dump( pack('c',12) );
dump( unpack( 'H*', pack('c',12) ) );



exit;
$pdo = include LIB_PATH.'/pdo.php';

// $pdo->query("UPDATE admin_menu SET parent_id=12 WHERE id=1");

// $pdo->exec("INSERT INTO admin_menu (parent_id) VALUES (233)");

$rs = $pdo->query("SELECT @@IDENTITY as id");
// $rs = $pdo->query("SELECT last_insert_id() ");
$rs = $rs->fetchAll(PDO::FETCH_ASSOC);
dump($rs);

include_once 'head.php';
?>



