<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'price', 'category', 'description', 'image', 'capacity', 'size'
    ];

    public function category() 
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    

    public function reservation() 
    {
        return $this->hasMany(Reservation::class);
    }

}
