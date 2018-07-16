<?php
namespace app\main\controller;

class Index {
	
	public function index() 
	{
		return 'main->index->index';
	}
	
	public function cof()
	{
// 		$c =  \Think\Config::get('default_return_type');
// 		$c =  \Think\Config::get('database.type');
		$c =  \Think\Config::get('salvare.moon');
		dump($c);
		exit;
	}
	
	public function env() 
	{
// 		phpinfo();exit;
		
		dump( getenv('REMOTE_ADDR') );
		dump( $_SERVER['REMOTE_ADDR'] );
		
		dump( getenv('TEMP') );
		dump( $_SERVER['TEMP'] );
		exit;
	}
	
	public function err()
	{
		$aa['bb'];
		exit;
	}
	
}