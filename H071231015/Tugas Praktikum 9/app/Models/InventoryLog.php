<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    protected $fillable = [
        'product_id',
        'type',
        'quantity', 
        'date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}