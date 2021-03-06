<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product1C extends Model
{
    use SoftDeletes;

    protected $table = 'products_1c';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function scopeHasStock($query)
    {
        return $query->where('stock', '>=', 1)->where('price', '>=', 1);
    }

    public function scopeAvailability($query, $availability)
    {
        if ($availability === 'no') {
            return $query->where('stock', 0);
        } elseif ($availability === 'yes') {
            return $query->where('stock', '>=', 1);
        } else {
            return $query;
        }
    }

    public function scopeGetTypeOfDiscount($query, $typeF = [0])
    {
        if (in_array(0, $typeF)) {
            return $query->where('promotion_type', '>', 0);
        } elseif (in_array(2, $typeF)) {
            return $query->where('promotion_type', '>=', 2);
        } else {
            return $query->whereIn('promotion_type', $typeF);
        }
    }
}
