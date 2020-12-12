<?php

namespace App\Listeners;

use App\Entities\TransferAudit;
use App\Events\TransferCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyTransferCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TransferAudit $model)
    {
        $this->model = $model;
    }


    /**
     * Handle the event.
     *
     * @param  TransferCreated  $event
     * @return void
     */
    public function handle(TransferCreated $event)
    {
        //store audit data
        if ($event->transfer) {

            //create user archive
            $item = $this->model->create($event->transfer->toArray());

            return $item;

        }
    }
}
