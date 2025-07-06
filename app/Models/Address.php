<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
class Address extends Model
{
    protected $table = "addresses";
    protected $fillable = [
        "id",
        "country",
        "city",
        "postal_code",
        "street",
        "full_address",
        "created_at",
    ];
    public function properties() {
        return $this->hasMany(Property::class);
    }
}
