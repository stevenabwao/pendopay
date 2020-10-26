<?php

namespace App\Listeners;

use App\Entities\UserAudit;
use App\Events\UserUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUserUpdated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserAudit $model)
    {
        $this->model = $model;
    }

    /**
     * Handle the event.
     *
     * @param  UserUpdated  $event
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        // store audit data
        if ($event->user) {

            //create user archive
            $user = $this->model->create($event->user->toArray());

            return $user;

        }
    }
}
