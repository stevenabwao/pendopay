<?php

namespace App\Providers;

use App\Listeners\NotifyUserCreated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    /* protected $listen2 = [
        UserCreated::class => [
            SendEmailVerificationNotification::class,
            NotifyUserCreated::class,
        ],
    ]; */

    protected $listen = [
        'App\Events\UserCreated' => [
            'App\Listeners\NotifyUserCreated',
        ],
        'App\Events\UserUpdated' => [
            'App\Listeners\NotifyUserUpdated',
        ],
        'App\Events\DepositAccountCreated' => [
            'App\Listeners\NotifyDepositAccountCreated',
        ],
        'App\Events\DepositAccountUpdated' => [
            'App\Listeners\NotifyDepositAccountUpdated',
        ],
        'App\Events\TransactionCreated' => [
            'App\Listeners\NotifyTransactionCreated',
        ],
        'App\Events\TransactionUpdated' => [
            'App\Listeners\NotifyTransactionUpdated',
        ],
        'App\Events\TransactionAccountCreated' => [
            'App\Listeners\NotifyTransactionAccountCreated',
        ],
        'App\Events\TransactionAccountUpdated' => [
            'App\Listeners\NotifyTransactionAccountUpdated',
        ],
        'App\Events\TransferCreated' => [
            'App\Listeners\NotifyTransferCreated',
        ],
        'App\Events\TransferUpdated' => [
            'App\Listeners\NotifyTransferUpdated',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
