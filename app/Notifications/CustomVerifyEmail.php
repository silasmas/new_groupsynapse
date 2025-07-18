<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
class CustomVerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
{
    $verificationUrl = $this->verificationUrl($notifiable);

    return (new MailMessage)
        ->subject('Confirmation de votre adresse e-mail')
        ->greeting('👋 Bonjour et bienvenue sur GROUPSYNAPSE !')
        ->line('Merci de vous être inscrit. Pour activer votre compte, veuillez cliquer sur le bouton ci-dessous afin de confirmer votre adresse e-mail.')
        ->action('Confirmer mon adresse email', $verificationUrl)
        ->line('Si vous n’avez pas demandé la création d’un compte, aucune action n’est requise.')
        ->salutation('— L’équipe GROUPSYNAPSE');
}

    protected function verificationUrl($notifiable)
    {
        // return URL::temporarySignedRoute(
        //     'verification.verify',
        //     Carbon::now()->addMinutes(60),
        //     ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        // );
         return URL::temporarySignedRoute(
        'verification.verify', // <-- DOIT correspondre à ta route personnalisée
        now()->addMinutes(60),
        [
            'id' => $notifiable->getKey(),
            'hash' => sha1($notifiable->getEmailForVerification()),
        ]
    );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
