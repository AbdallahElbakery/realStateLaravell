<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        "id",
        "user_id",
        "message",
        "is_read",
        "created_at",
        "updated_at",
        "deleted_at",
    ];
}
