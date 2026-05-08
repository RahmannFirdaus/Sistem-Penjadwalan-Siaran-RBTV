<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\LoginHistory;
use Illuminate\Http\Request;

class RecordLoginHistory
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Login $event)
    {
        LoginHistory::create([
            'user_id'    => $event->user->id,
            'ip_address' => $this->request->ip(),
            'user_agent' => $this->request->userAgent(),
            'login_time' => now(),
        ]);
    }
}