<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        "name",
        "description",
        "price",
        "city",
        "payment_method",
        "purpose",
        "status",
        "area",
        "bedrooms",
        "created_at",
        "updated_at",
        "seller_id",
        "category_id",
        "address_id",
    ];
}
