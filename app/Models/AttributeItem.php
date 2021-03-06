<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeItem extends Model
{
    public $timestamps = false;
    protected $table = 'attribute_item';

    protected $guarded = [];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attribute', 'attribute_id', 'product_id');
    }
}
