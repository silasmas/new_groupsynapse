<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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


	public function paniers()
	{
		
		return $this->hasMany(\App\Models\Panier::class);
	
	}


	public function commandes()
	{
		
		return $this->belongsToMany(\App\Models\Commande::class);
	
	}

}
