<?php

namespace App\Listeners;

use App\Entities\TransactionAccountAudit;
use App\Events\TransactionAccountUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyTransactionAccountUpdated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TransactionAccountAudit $model)
    {
        $this->model = $model;
    }

    /**
     * Handle the event.
     *
     * @param  TransactionAccountUpdated  $event
     * @return void
     */
    public function handle(TransactionAccountUpdated $event)
    {
        //store audit data
        if ($event->transactionaccount) {

            //create user archive
            $item = $this->model->create($event->transactionaccount->toArray());

            return $item;

        }
    }
}
