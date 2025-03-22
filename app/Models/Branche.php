<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branche extends Model
{
    use HasFactory;

	protected $fillable = ['name', 'slug', 'description', 'isActive', 'vignette','position'];

	public function categorie()
	{

		return $this->hasMany(Category::class);

	}

}
