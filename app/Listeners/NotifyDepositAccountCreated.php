<?php

namespace App\Listeners;

use App\Entities\DepositAccountAudit;
use App\Events\DepositAccountCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyDepositAccountCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(DepositAccountAudit $model)
    {
        $this->model = $model;
    }


    /**
     * Handle the event.
     *
     * @param  DepositAccountCreated  $event
     * @return void
     */
    public function handle(DepositAccountCreated $event)
    {
        //store audit data
        if ($event->depositaccount) {

            //create user archive
            $item = $this->model->create($event->depositaccount->toArray());

            return $item;

        }
    }
}
