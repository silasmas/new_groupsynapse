<?php
namespace App\Models;

use App\Models\Category;
use App\Models\Panier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $casts = [
        'prix'      => 'double',
        'imageUrls' => 'array',
    ];

    public function getFirstImageAttribute()
    {
        // Vérifie si la colonne est un tableau, sinon la décoder manuellement
        $images = is_array($this->imageUrls) ? $this->imageUrls : json_decode($this->imageUrls, true);

        return ! empty($images) ? $images[0] : 'default.jpg';
    }

    public function getFirstImageAttribute2()
    {
        // Vérifie si la colonne est un tableau, sinon la décoder manuellement
        $images = is_array($this->imageUrls) ? $this->imageUrls : json_decode($this->imageUrls, true);

        return $this->imageUrls;
        //  return !empty($images) ? $images : 'default.jpg';
    }

    public function categories()
    {

        // return $this->belongsToMany(Category::class);
        return $this->belongsToMany(Category::class, 'category_produit', 'produit_id', 'category_id');

    }

    public function getImageUrlsAttribute()
    {
        if (! isset($this->attributes['imageUrls']) || empty($this->attributes['imageUrls'])) {
            return [];
        }

        // Décoder le JSON en tableau PHP
        $images = json_decode($this->attributes['imageUrls'], true);

        // Vérifier que c'est bien un tableau
        if (! is_array($images)) {
            return [];
        }

        // Si on est dans Filament (édition), on retourne directement les chemins bruts
        if (request()->is('admin/*')) {
            return $images; // Ne pas transformer en URLs pour éviter les problèmes avec FileUpload
        }

        // Si c'est pour affichage sur le site, transformer en URLs complètes
        return array_map(function ($path) {
            return str_starts_with($path, 'assets/')
            ? asset($path)
            : asset("storage/{$path}");
        }, $images);
    }

    protected $fillable = ['isProduct', 'name', 'slug', 'description', 'moreDescription', 'additionalInfos', 'stock', 'prix', 'currency', 'soldePrice', 'imageUrls', 'brand', 'isAvalable', 'isBestseler', 'isNewArivale', 'isFeatured', 'isSpecialOffer', 'category'];

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

        return $this->hasMany(Panier::class);

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
