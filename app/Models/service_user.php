<?php

namespace App\Models;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class service_user extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'livraison' => 'boolean',
    ];
    
   public function user()
	{

		return $this->belongsTo(\App\Models\User::class);

	}


	public function service()
	{
		return $this->belongsTo(\App\Models\Service::class);

	}
    public function getPhotoUrlAttribute()
    {
        return $this->photo_identite ? asset('storage/' . $this->photo_identite) : null;
    }
    public function getPieceUrlAttribute()
    {
        return $this->piece_identite ? asset('storage/' . $this->piece_identite) : null;
    }
    public function getEtatLabelAttribute()
    {
        $labels = [
            'initialisé' => 'info',
            'en cours' => 'warning',
            'terminé' => 'success',
            'annulé' => 'danger',
        ];
        return $labels[$this->etat] ?? 'secondary';
    }
    public function getEtatTextAttribute()
    {
        $texts = [
            'initialisé' => 'Initialisé',
            'en cours' => 'En cours',
            'terminé' => 'Terminé',
            'annulé' => 'Annulé',
        ];
        return $texts[$this->etat] ?? 'Inconnu';
    }
}
