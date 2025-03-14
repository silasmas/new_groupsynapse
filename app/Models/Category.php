<?php

namespace App\Models;

use App\Models\Branche;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

	public function branches()
	{

		return $this->belongsTo(Branche::class);

	}


	protected $fillable = ['name', 'slug', 'description', 'vignette', 'isActive', 'branche'];

	public function produits()
	{

		return $this->belongsToMany(\App\Models\Produit::class);

	}

}
