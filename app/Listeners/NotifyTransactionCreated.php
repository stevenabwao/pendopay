<?php

namespace App\Listeners;

use App\Entities\TransactionAudit;
use App\Events\TransactionCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyTransactionCreated
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
     * @param  TransactionCreated  $event
     * @return void
     */
    public function handle(TransactionCreated $event)
    {
        //store audit data
        if ($event->transaction) {

            //create user archive
            $item = $this->model->create($event->transaction->toArray());

            return $item;

        }
    }
}
