<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\ActivityLog;

class LogSuccessfulLogin
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        ActivityLog::create([
            'user_id' => $event->user->id,
            'action' => 'Login',
            'description' => 'User login ke sistem',
        ]);
    }
}
