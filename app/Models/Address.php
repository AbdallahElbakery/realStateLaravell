<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
class Address extends Model
{
    protected $table = "addresses";
    protected $fillable = [
        "country",
        "city",
        "postal_code",
        "street",
        "full_address",
        "image",
    ];
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
