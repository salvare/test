<?php 
namespace SmartWiki\Listeners;

class SomeEventSubscriber
{
	
	public function handle_a($event) {
		dump('SomeEventSubscriber@handle_a');
		dump($event);
	}
	
	public function handle_b($event) {
		dump('SomeEventSubscriber@handle_b');
		dump($event);
	}
	
	/**
	 * 为订阅者注册监听器.
	 *
	 * @param  Illuminate\Events\Dispatcher  $events
	 */
	public function subscribe($events)
	{
		$events->listen(
			'SmartWiki\Events\SomeEvent',
			'SmartWiki\Listeners\SomeEventSubscriber@handle_a',
			50
		);
	
		$events->listen(
			'SmartWiki\Events\SomeEvent',
			'SmartWiki\Listeners\SomeEventSubscriber@handle_b',
			10
		);
		
		$events->listen(
			'SmartWiki\Events\SomeEvent',
			function($event) {
				dump('SomeEventSubscriber@Closure');
				dump($event);
			},
			100
		);
	}
	
}

?>