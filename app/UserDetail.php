<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'phone_number',
        'user_address'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
