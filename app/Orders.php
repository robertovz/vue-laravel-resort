<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
    'product_id', 'user_id', 'user_name', 'user_email', 'check_in', 'check_out', 'price', 'status'
    ];
    
    public function product() 
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}


