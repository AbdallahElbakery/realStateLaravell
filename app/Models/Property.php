<?php

namespace App\Models;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        "name",
        "description",
        "price",
        "citynum",
        "payment_method",
        "purpose",
        "status",
        "area",
        "bedrooms",
        "bathrooms",
        "created_at",
        "updated_at",
        "seller_id",
        "category_id",
        "address_id",
        "image",
    ];
    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
