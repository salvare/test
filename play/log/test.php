<?php
include_once 'public.php';
// include_once LIB_PATH.'/log-master';

use Psr\Log\LoggerInterface;

class Foo
{
	private $logger;

	public function __construct(LoggerInterface $logger = null)
	{
		$this->logger = $logger;
	}

	public function doSomething()
	{
		if ($this->logger) {
			$this->logger->info('Doing work');
		}

		// do something useful
		echo 'doSomething';
	}
}

$foo = new Foo();
$foo->doSomething();