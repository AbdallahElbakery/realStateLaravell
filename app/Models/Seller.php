<?php

namespace App\Models;
use App\Models\User;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $fillable = [
        "user_id",
        "company_name",
        "about_company",
        "logo",
        "personal_id_image",
        "status",
        "created_at",
        "updated_at",
        "updated_at",
        "password"
        // "own_properties",
        
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function properties()
    {
        return $this->hasMany(Property::class, 'seller_id', 'user_id');
    }

}
