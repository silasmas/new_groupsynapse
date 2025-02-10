<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branche extends Model
{
    use HasFactory;

	protected $fillable = ['name', 'slug', 'description', 'isActive', 'vignette'];

	public function category()
	{

		return $this->hasMany(\App\Models\Category::class);

	}

}
