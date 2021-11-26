<?php

namespace App\Providers;

use App\Events\WechatMemberViewEvent;
use App\Events\WechatMemberViewTagsEvent;
use App\Listeners\WechatMemberViewListener;
use App\Listeners\WechatMemberViewTagsListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        WechatMemberViewEvent::class => [
            WechatMemberViewListener::class
        ],
        WechatMemberViewTagsEvent::class => [
            WechatMemberViewTagsListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
