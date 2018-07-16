<?php
// 路径
define( 'HOST', $_SERVER['HTTP_HOST'] );
define( 'URI', $_SERVER['REQUEST_URI'] );
define( 'DOMAIN', 'http://'.HOST );
define( 'URL', DOMAIN.URI );
define( 'ROOT_PATH', dirname(dirname(__FILE__)));
define( 'PUB_PATH', ROOT_PATH.'/public');
define( 'LIB_PATH', PUB_PATH.'/library');
define( 'RES_PATH', PUB_PATH.'/res');
define( 'TEST_URL', 'http://www.test.com');

// 请求方式 
define( 'IS_POST', isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST');
define( 'IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
define( 'IS_PJAX', array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']);
define( 'IS_CLI', PHP_SAPI == 'cli' ? true : false);

set_time_limit(0);
error_reporting( E_ALL ^ E_NOTICE );

include_once PUB_PATH.'\function.php';
include_once LIB_PATH.'\cache.lib.php';

define( 'CACHE_SERVER', 'redis' );
define( 'CACHE_HOST', 'localhost' );
define( 'CACHE_PORT', '6379' );
?>