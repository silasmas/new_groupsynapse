<?php

namespace App\Listeners;

use App\Models\ConnectionLog;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;

class RecordUserLogout
{
    public function __construct(
        protected Request $request
    ) {}

    public function handle(Logout $event): void
    {
        if (!$event->user || !$this->request->hasSession()) {
            return;
        }

        $sessionId = $this->request->session()->getId();

        ConnectionLog::where('user_id', $event->user->getKey())
            ->where('session_id', $sessionId)
            ->whereNull('disconnected_at')
            ->update(['disconnected_at' => now()]);
    }
}
