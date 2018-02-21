<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'buy_sell', 'quantity', 'currency', 'sum', 'provision', 'pdv', 'amount', 'success'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
