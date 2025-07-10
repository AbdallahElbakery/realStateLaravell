<?php

namespace App\Models;
use App\Models\Property;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        "id",
        "property_id",
        "image",
        "created_at",
        "updated_at",
        "deleted_at",
    ];
    public function property(){
        return $this->belongsTo(Property::class);
    }
}
