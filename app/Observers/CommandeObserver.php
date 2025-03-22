<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Message;
use App\Models\Commande;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageNotificationMail;

class CommandeObserver
{
    /**
     * Handle the Message "created" event.
     */
    public function created(Commande $message): void
    {
        $this->notifyUsers($message, 'envoyée');
    }

    /**
     * Handle the Message "updated" event.
     */
    public function updated(Commande $message): void
    {
        $this->notifyUsers($message, 'modifiée');
    }

    /**
     * Handle the Message "deleted" event.
     */
    public function deleted(Commande $message): void
    {
        $this->notifyUsers($message, 'supprimer');
    }

    /**
     * Handle the Message "restored" event.
     */
    public function restored(Commande $message): void
    {
        //
    }

    /**
     * Handle the Message "force deleted" event.
     */
    public function forceDeleted(Commande $message): void
    {
        //
    }
    protected function notifyUsers(Commande $message, string $action): void
    {
        // Récupérer tous les utilisateurs notifiables
        $users = User::where('notifiable', 1)->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new MessageNotificationMail($user, $message, $action));
        }
    }
}
