<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorie extends Model
{
    use HasFactory;

	public function user()
	{

		return $this->belongsTo(\App\Models\User::class);

	}


	public function produit()
	{

		return $this->belongsTo(\App\Models\Produit::class);

	}


	protected $fillable = ['user_id', 'produit_id'];
}
