<?php

namespace App\Models;

use App\Models\User;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;

	// public function produits()
	// {

	// 	return $this->belongsToMany(\App\Models\Produit::class);

	// }
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'commande_produit')
            ->withPivot('quantite', 'prix_unitaire', 'prix_total')
            ->withTimestamps();
    }

	// public function users()
	// {

	// 	return $this->belongsToMany(\App\Models\User::class);

	// }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


	protected $guarded = [];

	public function transaction()
	{

		return $this->belongsTo(\App\Models\Transaction::class);

	}

}
