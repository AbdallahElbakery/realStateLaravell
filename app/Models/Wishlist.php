<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = "wishlists";
    public $timestamps = false;

    protected $fillable = [
        "user_id",
        "property_id",
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
