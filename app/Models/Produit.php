<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $casts = [
        'prix' => 'double',
    ];

    public function getFirstImageAttribute()
    {
         // Vérifie si la colonne est un tableau, sinon la décoder manuellement
         $images = is_array($this->imageUrls) ? $this->imageUrls : json_decode($this->imageUrls, true);

         return !empty($images) ? $images[0] : 'default.jpg';
    }

	public function categories()
	{

		return $this->belongsToMany(\App\Models\Category::class);

	}
    public function imageUrls()
    {

        return json_decode($this->imageUrls);
    }

	protected $fillable = ['name', 'slug', 'description', 'moreDescription', 'additionalInfos', 'stock', 'prix', 'currency', 'soldePrice', 'imageUrls', 'brand', 'isAvalable', 'isBestseler', 'isNewArivale', 'isFeatured', 'isSpecialOffer', 'category'];

	public function favories()
	{

		return $this->hasMany(Favorie::class, 'produit_id', 'id')
        ->where('user_id', auth()->id());

	}
    public function users()
{
    return $this->belongsToMany(User::class, 'favories', 'produit_id', 'user_id')
                ->withPivot('created_at', 'updated_at');
}


	public function paniers()
	{

		return $this->hasMany(\App\Models\Panier::class);

	}


	// public function commandes()
	// {

	// 	return $this->belongsToMany(\App\Models\Commande::class);

	// }
    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_produit')
            ->withPivot('quantite', 'prix_unitaire', 'prix_total')
            ->withTimestamps();
    }

}
