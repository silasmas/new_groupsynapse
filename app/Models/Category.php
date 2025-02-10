<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

	public function branches()
	{

		return $this->belongsTo(\App\Models\Branche::class);

	}


	protected $fillable = ['name', 'slug', 'description', 'vignette', 'isActive', 'branche'];

	public function produits()
	{

		return $this->belongsToMany(\App\Models\Produit::class);

	}

}
