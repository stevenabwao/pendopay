<?php

namespace App\Listeners;

use App\Entities\TransferAudit;
use App\Events\TransferUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyTransferUpdated
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
     * @param  TransferUpdated  $event
     * @return void
     */
    public function handle(TransferUpdated $event)
    {
        //store audit data
        if ($event->transfer) {

            //create user archive
            $item = $this->model->create($event->transfer->toArray());

            return $item;

        }
    }
}
