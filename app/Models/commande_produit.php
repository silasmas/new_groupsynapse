<?php

namespace App\Models;

use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande_produit extends Model
{
    use HasFactory;
    protected $table = 'Commande_produit';
	protected $guarded = [];
/**
     * Relation avec la commande
     */
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    /**
     * Relation avec le produit
     */
    public function product()
    {
        return $this->belongsTo(Produit::class);
    }

}

