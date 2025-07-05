<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $fillable = [
        "user_id",
        "company_name",
        "logo",
        "personal_id_image",
        "status",
        "created_at",
        "updated_at",
        "updated_at",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
