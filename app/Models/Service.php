<?php
namespace App\Models;

use App\Models\Category;
use App\Models\Favorie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $casts = [
    //     'prix'      => 'double',
    // ];
    public function categories()
    {
        return $this->belongsTo(Category::class,  'category_id');
    }
    public function favories()
    {
        return $this->hasMany(Favorie::class, 'service_id', 'id')
            ->where('user_id', auth()->id());
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'favories', 'produit_id', 'user_id')
            ->withPivot('created_at', 'updated_at');
    }
     public function user()
    {
        return $this->belongsToMany(User::class, 'service_users', 'user_id', 'service_id')->withPivot('created_at', 'updated_at');
    }
}
