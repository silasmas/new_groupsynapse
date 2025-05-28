<?php

namespace App\Models;

use App\Models\Branche;
use App\Models\Produit;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

	public function branche()
	{

		return $this->belongsTo(Branche::class);

	}


	protected $fillable = ['name', 'slug', 'description', 'vignette', 'isActive', 'branche_id'];

	public function produits()
	{

		// return $this->belongsToMany(Produit::class);
        return $this->belongsToMany(Produit::class, 'category_produit', 'produit_id', 'category_id');


	}
	public function services()
	{

		// return $this->belongsToMany(Produit::class);
        return $this->hasMany(Service::class,  'category_id');


	}

}
