<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'operator',
        'price',
        'views',
        'location',
        'expires_at',
        'image_url',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'expires_at' => 'datetime',
        'is_featured' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i',
    ];

    public function scopeByOperator($query, $operator)
    {
        return $query->where('operator', $operator);
    }

    public function scopeByLocation($query, $location)
    {
        return $query->where('location', 'like', '%' . $location . '%');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeActive($query)
    {
        return $query->where('expires_at', '>', Carbon::now());
    }

    public function scopePriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    public function getIsExpiredAttribute()
    {
        return $this->expires_at < Carbon::now();
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price) . ' تومان';
    }


    public function incrementViews()
    {
        $this->increment('views');
    }
}
