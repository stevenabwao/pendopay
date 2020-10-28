<?php

namespace App\Events;

use App\Entities\DepositAccount;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DepositAccountUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $depositaccount;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DepositAccount $depositaccount)
    {
        $this->depositaccount = $depositaccount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
