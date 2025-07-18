<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Service;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\CustomVerifyEmail;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
public function sendEmailVerificationNotification()
{
    $this->notify(new CustomVerifyEmail);
}
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

}
