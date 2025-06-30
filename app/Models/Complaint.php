<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        "user_id",
        "subject",
        "message",
        "status",
        "created_at",
        "updated_at",
        "deleted_at",
    ];
}
