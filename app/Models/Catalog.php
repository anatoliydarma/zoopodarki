<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $table = 'catalogs';
    protected $guarded = [];

    public $timestamps = false;

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->hasManyDeep(Product::class, [Category::class, 'product_category']);
    }

    public function brandsById()
    {
        return $this->belongsToMany(Brand::class, 'catalog_brand', 'catalog_id', 'brand_id');
    }
}
