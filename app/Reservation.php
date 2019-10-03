<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'product_id', 'user_id', 'user_name', 'user_email', 'check_in', 'check_out', 'price', 'message', 'status'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
    public function product() 
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
