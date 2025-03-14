<?php

namespace App\Mail;

use App\Models\Commande;
use App\Models\User;
use App\Models\Requete;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $commande;
    public $action;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Commande $commande, string $action)
    {
        $this->user = $user;
        $this->commande = $commande;
        $this->action = $action;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->subject('Mise à jour des messages')
            ->view('emails.message_notification')
            ->with([
                'userName' => $this->user->name,
                'messageContent' => $this->commande->commande,
                'action' => $this->action,
            ]);
    }
}
