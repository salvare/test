<?php

namespace ns\a;

Class A {
	
	function __construct()
	{
		dump('ns\a\A');
	}
	
}

Class R {
	
	function __construct()
	{
		dump('ns\a\R');
	}
	
}

function a() 
{
	dump('ns\a\a()');
}

function r()
{
	dump('ns\a\r()');
}