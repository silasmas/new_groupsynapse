<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

	public function commandes()
	{
		
		return $this->hasMany(\App\Models\Commande::class);
	
	}


	protected $fillable = ['reference', 'provider_reference', 'oreder_number', 'amount_costumer', 'currency', 'chanel', 'description', 'commande_id', 'etat'];
}
