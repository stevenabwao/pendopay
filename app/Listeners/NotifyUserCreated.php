<?php

namespace App\Listeners;

use App\Entities\UserAudit;
use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUserCreated
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
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        // store audit data
        if ($event->user) {

            $phone = $event->user->phone;
            $email = $event->user->email;

            // send account activation email/ sms
            // sendAccountActivationDetails($phone, $email);

            //create user archive
            $user = $this->model->create($event->user->toArray());

            return $user;

        }
    }

}
