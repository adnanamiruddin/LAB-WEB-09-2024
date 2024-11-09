<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category_id'
    ];


    public function category() 
    {
        return $this->belongsto(Category::class);
    }

    public function InventoryLog() 
    {
        return $this->hasMany(InventoryLog::class);
    }
}
