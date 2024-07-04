<?php

namespace App\Listeners\Order;

use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Order\SendOrderDetailsToAdminEvent;
use App\Notifications\Order\OrderDetailsToAdminNotification;

class SendOrderDetailsToAdminListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendOrderDetailsToAdminEvent $event): void
    {
        $order = $event->order;
        $admin = User::whereAdmin('1')->first();
        $admin->notify(new OrderDetailsToAdminNotification($order));
    }
}
