<?php

namespace App\Models;

use App\Models\Service;
use Filament\Models\Contracts\HasAvatar;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements HasAvatar
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * Vérification email désactivée - retourne toujours true.
     */
    public function hasVerifiedEmail(): bool
    {
        return true;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'prenom',
        'profil',
        'email',
        'password',
        'phone',
        'sexe',
        'pays',
        'adresse',
        'adresse_livraison',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

	public function favories()
	{

		// return $this->hasMany(\App\Models\Favorie::class);
        return $this->belongsToMany(Produit::class, 'favories', 'user_id', 'produit_id')
        ->withPivot('created_at', 'updated_at');

	}
public function service()
    {
        return $this->belongsToMany(Service::class, 'service_users', 'user_id', 'service_id')->withPivot('created_at', 'updated_at');
    }

	public function paniers()
	{

		return $this->hasMany(\App\Models\Panier::class);

	}


	public function commandes()
	{

		return $this->belongsToMany(\App\Models\Commande::class);

	}

	public function connectionLogs()
	{
		return $this->hasMany(ConnectionLog::class);
	}

	/** URL de l'avatar pour le menu Filament */
	public function getFilamentAvatarUrl(): ?string
	{
		return $this->profil ? asset('storage/' . $this->profil) : null;
	}

	/** Vérifie si l'utilisateur est super_admin (peut supprimer tout commentaire) */
	public function isSuperAdmin(): bool
	{
		$emails = array_filter(array_map('trim', explode(',', (string) config('app.super_admin_emails', ''))));
		return !empty($emails) && in_array($this->email, $emails);
	}

}
