<?php

namespace App\Models;

use App\Models\User;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;
    protected $dates = ['created_at', 'updated_at'];
	// public function users()
	// {

	// 	return $this->belongsToMany(\App\Models\User::class);

	// }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


	protected $guarded = [];

    /**
     * Relation avec les produits commandés (Une commande contient plusieurs produits)
     */
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'commande_produit')
                    ->withPivot('quantite', 'prix_unitaire', 'prix_total')
                    ->withTimestamps();
    }

}

