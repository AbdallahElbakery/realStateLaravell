<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;


class Admin extends Model
{   
    protected $table='admins';
    protected $primary_key='user_id';
    protected $auto_increment=false;
    protected $fillable=[
        'name',
        'email',
        'password',
        'phone',
        'photo',
        'address_id',
        'role',
    ];


    public function user(){
        return $this->belongsTo(User::class); 
    }
}
