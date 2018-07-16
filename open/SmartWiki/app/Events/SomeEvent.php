<?php

namespace SmartWiki\Events;

use SmartWiki\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SomeEvent extends Event
{
    use SerializesModels;
    
    public $msg;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($msg='')
    {
        //
        $this->msg = $msg;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
