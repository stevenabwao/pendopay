<?php

namespace App\Events;

use App\Entities\TransactionAccount;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionAccountCreated
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $transactionaccount;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(TransactionAccount $transactionaccount)
    {
        $this->transactionaccount = $transactionaccount;
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
