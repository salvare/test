<?php
/**
 * Created by PhpStorm.
 * User: lifeilin
 * Date: 2016/11/21 0021
 * Time: 16:16
 */

namespace SmartWiki\Http\Controllers;

use SmartWiki\Exceptions\DataException;
use PDO;

class InstallController extends Controller
{
	public function test() 
	{
		dump(__FUNCTION__);
	}

    public function next()
    {
    	return 'next';
    	
    	// Create the logger
    	$logger = new \Monolog\Logger('first');
    	// Now add some handlers
    	$logger->pushHandler(new \Monolog\Handler\StreamHandler(storage_path('logs/debug.log'), \Monolog\Logger::DEBUG));
    	$logger->pushHandler(new \Monolog\Handler\StreamHandler(storage_path('logs/info.log'), \Monolog\Logger::INFO));
    	
    	// You can now use your logger
    	$logger->info('info', ['a']);
    	$logger->debug('debug', ['b'=>'c']);
    	
    	return;
    	$app = app();
    	
//     	$app['events']->fire(new \SmartWiki\Events\SomeEvent('hello'), [], true);
//     	$app['events']->fire('event.foo');
//     	dump($app['events']->resolveQueue());
//     	dump($app['events']);

//     	\Log::info('life is like a boat');
//         dump(\Carbon\Carbon::now()->addMinutes(10));exit;
        dispatch((new \SmartWiki\Jobs\SomeJob())
        	->delay(\Carbon\Carbon::now()->addSeconds(30))
        	->onConnection('database')
            ->onQueue('foo'));
        
    	return;
    	
        if($this->isPost()) {
            $dbHost = $this->request->input('dataAddress');
            $dbUser = $this->request->input('dataAccount');
            $dbName = $this->request->input('dataName');
            $dbPassword = $this->request->input('dataPassword');
            $dbPort = $this->request->input('dataPort','3306');

            $account = $this->request->input('account');
            $password = $this->request->input('password');
            $email = $this->request->input('email');

            try{
                system_install($dbHost,$dbName,$dbPort,$dbUser,$dbPassword,$account,$password,$email);
            }catch (\Exception $ex){
                return $this->jsonResult($ex->getCode(),null,$ex->getMessage());
            }

            @file_put_contents(public_path('install.lock'),'true');
            session('install.result',true);
            $url = (route('member.projects'));


            return $this->jsonResult(0,["url" => $url]);

        }
        return view('install.next',$this->data);
    }

}