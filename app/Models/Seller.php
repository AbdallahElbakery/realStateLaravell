<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Laravel\Sanctum\HasApiTokens;

class Seller extends Model
{
    use HasApiTokens;
    
    protected $fillable = [
        'user_id',
        'company_name',
        'logo',
        'personal_id_image',
        'status',
    ];
    
    public function user()
    {
        return $this->hasOne(User::class);
    }
    
}
