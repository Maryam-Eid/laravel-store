<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope('store', function (Builder $builder) {
            if (Auth::user() && Auth::user()->store_id) {
                $builder->where('store_id', Auth::user()->store_id);
            }
        });

        static::creating(function (Product $product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public $appends = [
        'image_url',
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at', 'image',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', 'active');
    }

    public function getImageUrlAttribute()
    {
        if (! $this->image) {
            return 'https://grafgearboxes.com/productos/images/df.jpg';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return asset('storage/'.$this->image);
    }

    public function getSalePercentAttribute()
    {
        if (! $this->compare_price) {
            return 0;
        }

        return round(100 - (100 * $this->price / $this->compare_price), 1);
    }

    public function scopeFilter(Builder $builder, array $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['store_id'], fn ($query, $store_id) => $query->where('store_id', $store_id))
            ->when($options['category_id'], fn ($query, $category_id) => $query->where('category_id', $category_id))
            ->when($options['tag_id'], fn ($query, $tag_id) => $query->whereHas('tags', fn ($query) => $query->where('id', $tag_id)))
            ->when($options['status'], fn ($query, $status) => $query->where('status', $status));

        return $builder;
    }
}
