<?php
namespace App\Observers;

use App\Mail\ServiceNotificationMail;
use App\Models\Service;
use App\Models\service_user;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ServiceUserObserver
{
    /**
     * Handle the ServiceUser "created" event.
     */
    public function created(service_user $serviceUser): void
    {
        if ($serviceUser->etat === 'init') {
            // Exemple : log ou notification à l’admin
            // Log::info("Nouvelle transaction initiée : ".$serviceUser->reference);
        }
    }

    /**
     * Handle the ServiceUser "updated" event.
     */
    public function updated(service_user $serviceUser): void
    {
        \Log::info('Info service update :', $serviceUser);
        if ($serviceUser->isDirty('etat')) {
            $nouvelEtat = $serviceUser->etat;
            \Log::info('Info service etat :', $nouvelEtat);

            if ($nouvelEtat === 'Payée') {
                $this->notifierSucces($serviceUser);
            } else {
                $this->notifierEchec($serviceUser);
            }
        }
    }

    /**
     * Handle the ServiceUser "deleted" event.
     */
    public function deleted(service_user $serviceUser): void
    {
        //
    }

    /**
     * Handle the ServiceUser "restored" event.
     */
    public function restored(service_user $serviceUser): void
    {
        //
    }

    /**
     * Handle the ServiceUser "force deleted" event.
     */
    public function forceDeleted(service_user $serviceUser): void
    {
        //
    }
    protected function notifierSucces(service_user $serviceUser)
    {
        try {
            \Log::info('Info service :', $serviceUser);
            $service = Service::find($serviceUser->service_id);
            \Log::info('service :', $service);

            if ($service->slug == "recharge-carte") {
                $sms = $service->name . ", merci de faire passé la commande. ID de la carte : " . $serviceUser->idCarte . " 4 derniers chiffres : " . $serviceUser->numero_carte . "Montant : " . $serviceUser->montantRecharge . $serviceUser->numero_carte .
                "Montant : " . $serviceUser->currency;
                $usersSms = User::where([['notifiable', true], ['phone', "!=", ""]])->get();
                foreach ($usersSms as $user) {
                    sendSms($$user->phone, $sms);
                }
            } else {
                // Récupérer tous les utilisateurs notifiables
                $users = User::where('notifiable', true)->get();

                foreach ($users as $user) {
                    $message = "Merci de bien vouloir vous connecter pour en savoir plus.";
                    Mail::to($user->email)->send(new ServiceNotificationMail($user, $message, $service->name));
                }
            }
        } catch (\Throwable $e) {
            \Log::info('info :', $e->getMessage());
        }

    }

    protected function notifierEchec(service_user $serviceUser)
    {
        try {
            \Log::info('Info service :', $serviceUser);
            // Mail d’échec
            // Récupérer tous les utilisateurs notifiables
            $users = User::where([["id", $serviceUser->user_id], ['notifiable', true]])->get();

            foreach ($users as $user) {
                $message = "Votre transaction pour le service " . $serviceUser->service->name . " a échoué. Veuillez réessayer ou contacter le support.";
                Mail::to($user->email)->send(new ServiceNotificationMail($user, $message, $serviceUser->service->name));
            }
        } catch (\Throwable $e) {
            \Log::info('info :', $e->getMessage());
        }
    }
}
