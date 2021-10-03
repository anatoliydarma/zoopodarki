<?php

namespace App\Models;

use App\Traits\Revieweable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
// TODO on in production
//use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;
    use PowerJoins;
    use Revieweable;
    use Sluggable;
    use SoftDeletes;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    use \Bkwld\Cloner\Cloneable;
    //use Searchable;

    protected $table = 'products';

    protected $guarded = [];

    protected $cloneable_relations = ['attributes', 'reviews', 'unit', 'brand', 'serie'];

    public function registerMediaConversions(Media $media = null): void
    {
        ini_set('memory_limit', '512M');

        $this->addMediaConversion('thumb')
            ->width(350)
            ->height(350)
            ->optimize()
            ->nonQueued()
            ->performOnCollections('product-images');

        $this->addMediaConversion('medium')
            ->width(800)
            ->height(800)
            ->optimize()
            ->nonQueued()
            ->performOnCollections('product-images');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('product-images')
            ->useFallbackUrl('/img/no-photo.jpg')
            ->useFallbackPath(public_path('/img/no-photo.jpg'));
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function searchableAs()
    {
        return 'products';
    }

    protected function makeAllSearchableUsing($query)
    {
        return $query->with('categories:id,slug')
            ->with('categories.catalog:id,slug')
            ->with('media');
    }

    public function toSearchableArray()
    {
        $array = $this->only('id', 'name', 'meta_title', 'description', 'slug');

        if ($this->categories()->exists()) {
            $array['category'] = $this->categories[0]['slug'];
            $array['catalog'] = $this->categories[0]->catalog['slug'];
        }

        if ($this->media()->count() > 0) {
            $array['image'] = $this->getFirstMediaUrl('product-images', 'thumb');
        }

        return $array;
    }

    public function shouldBeSearchable()
    {
        return $this->isPublished();
    }

    public function isPublished()
    {
        return $this->status === 'active';
    }

    public function scopeIsStatusActive($query)
    {
        return $query->where('status', 'active');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id');
    }

    public function variations()
    {
        return $this->hasMany('App\Models\Product1C');
    }

    public function attributes()
    {
        return $this->belongsToMany(AttributeItem::class, 'product_attribute', 'product_id', 'attribute_id');
    }

    public function parentAttribute()
    {
        return $this->hasManyDeepFromRelations($this->attributes(), (new AttributeItem())->attribute());
    }

    public function reviews()
    {
        return $this->morphMany('App\Models\Review', 'revieweable');
    }

    public function unit()
    {
        return $this->belongsTo(ProductUnit::class);
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }

    public function serie()
    {
        return $this->belongsTo('App\Models\BrandSerie', 'brand_serie_id');
    }

    public function favorites()
    {
        return $this->morphMany('App\Models\Favorite', 'favoritable');
    }
}