<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'user_id','account_no'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
