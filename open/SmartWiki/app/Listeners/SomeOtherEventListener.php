<?php

namespace SmartWiki\Listeners;

use SmartWiki\Events\SomeOtherEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SomeOtherEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle_foo()
    {
        dump('SomeOtherEventListener@handle_foo');
    }

    public function handle_bar()
    {
        dump('SomeOtherEventListener@handle_bar');
    }
    
}
