<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
    'user_id',
    'property_id',
    'suggested_price',
    'status',
];

public function property()
{
    return $this->belongsTo(Property::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}


}
