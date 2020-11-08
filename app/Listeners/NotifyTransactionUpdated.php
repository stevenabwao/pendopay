<?php

namespace App\Listeners;

use App\Entities\TransactionAudit;
use App\Events\TransactionUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyTransactionUpdated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TransactionAudit $model)
    {
        $this->model = $model;
    }

    /**
     * Handle the event.
     *
     * @param  TransactionUpdated  $event
     * @return void
     */
    public function handle(TransactionUpdated $event)
    {
        //store audit data
        if ($event->transaction) {

            //create user archive
            $item = $this->model->create($event->transaction->toArray());

            return $item;

        }
    }
}
