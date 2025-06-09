<?php
namespace App\Observers;

use App\Mail\ServiceNotificationMail;
use App\Models\Service;
use App\Models\service_user;
use App\Models\User;
use Illuminate\Support\Facades\Log;
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
          if (!$serviceUser->isDirty('etat')) {
        return; // Aucun changement de statut
    }

    $nouvelEtat = $serviceUser->etat;
   // Vérifie si on n’a pas déjà notifié ce statu
        if ($nouvelEtat === 'Payée' && !$serviceUser->notified_success) {
            //  Log::info('Transaction validée', $serviceUser->toArray());
            $this->notifierSucces($serviceUser);
            // Marquer comme notifié
        $serviceUser->notified_success = true;
        $serviceUser->saveQuietly(); // évite de relancer l'observer
        } else {
            //  Log::info('Transaction échouée', ['ref' => $serviceUser->reference]);
            $this->notifierEchec($serviceUser);
             $serviceUser->notified_failure = true;
        $serviceUser->saveQuietly();
        }
        // }
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
            $service = Service::find($serviceUser->service_id);

            if (! $service) {
                throw new \Exception("Service introuvable pour l'ID : " . $serviceUser->service_id);
            }

            // Récupération des utilisateurs à notifier
            $notifiables = User::where('notifiable', true)->get();

            if ($service->slug === "recharge-carte") {
                $sms = $service->name . ", merci de faire passer la commande. " .
                "ID carte : " . $serviceUser->idCarte .
                " | 4 derniers chiffres : " . $serviceUser->numero_carte .
                " | Montant : " . $serviceUser->montantRecharge . " " . $serviceUser->currency;

                foreach ($notifiables as $user) {
                    if (! empty($user->phone)) {
                        try {
                            sendSms($user->phone, $sms);
                        } catch (\Exception $ex) {
                            Log::error("Erreur envoi SMS à {$user->phone} : " . $ex->getMessage());
                        }
                    }
                }
            } else {
                $subject = $service->name;
                $message = "Merci de bien vouloir vous connecter pour en savoir plus.";

                foreach ($notifiables as $user) {
                    if (! empty($user->email)) {
                        try {
                            Mail::to($user->email)->send(new ServiceNotificationMail($user, $message, $subject));
                        } catch (\Exception $ex) {
                            Log::error("Erreur envoi email à {$user->email} : " . $ex->getMessage());
                        }
                    }
                }
            }

        } catch (\Throwable $e) {
            Log::error('Erreur dans la notification de service : ' . $e->getMessage(), [
                'service_user_id' => $serviceUser->id ?? null,
                'context'         => $serviceUser->toArray(),
            ]);
        }

    }

    protected function notifierEchec(service_user $serviceUser)
    {
        try {
            // Mail d’échec
            // Récupérer tous les utilisateurs notifiables
            $users = User::where([["id", $serviceUser->user_id], ['notifiable', true]])->get();

            foreach ($users as $user) {
                $message = "Votre transaction pour le service " . $serviceUser->service->name . " a échoué. Veuillez réessayer ou contacter le support.";
                Mail::to($user->email)->send(new ServiceNotificationMail($user, $message, $serviceUser->service->name));
            }
        } catch (\Throwable $e) {
        }
    }
}
