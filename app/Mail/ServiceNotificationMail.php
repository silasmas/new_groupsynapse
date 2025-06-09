<?php

namespace App\Mail;

use App\Models\Commande;
use App\Models\User;
use App\Models\Requete;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ServiceNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $service;
    public $action;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user,  $service, string $action)
    {
        $this->user = $user;
        $this->service = $service;
        $this->action = $action;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->subject('Service bancaire sollicité')
            ->view('emails.notification')
            ->with([
                'userName' => $this->user->name,
                'messageContent' => $this->service,
                'action' => $this->action,
            ]);
    }
}
