<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateLastLoginActivity
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
    public function handle(Login $event): void
    {
        // $event->user contiene la instancia del modelo User que acaba de autenticarse
        $event->user->timestamps = false;
        $event->user->update([
            'last_login_at' => now(),
        ]);
    }
}
