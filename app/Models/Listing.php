<?php

namespace App\Models;

use App\Models\User;
use App\Models\ListingImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['beds', 'baths', 'area', 'city', 'code', 'street', 'street_nr', 'price'];
    protected $sortable = [
        'price', 'created_at'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'by_user_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ListingImage::class);
    }

    public function scopeMostRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when(
            $filters['priceFrom'] ?? null,
            fn ($query, $value) => $query->where('price', '>=', $value)
        )->when(
            $filters['priceTo'] ?? null,
            fn ($query, $value) => $query->where('price', '<=', $value)
        )->when(
            $filters['areaFrom'] ?? null,
            fn ($query, $value) => $query->where('area', '>=', $value)
        )->when(
            $filters['areaTo'] ?? null,
            fn ($query, $value) => $query->where('area', '<=', $value)
        )->when(
            $filters['beds'] ?? null,
            fn ($query, $value) => $query->where('beds', (int) $value < 6 ? '=' : '>=', $value)
        )->when(
            $filters['baths'] ?? null,
            fn ($query, $value) => $query->where('baths', (int) $value < 6 ? '=' : '>=', $value)
        )->when(
            $filters['deleted'] ?? false,
            fn ($query, $value) => $query->withTrashed()
        )->when(
            $filters['by'] ?? false,
            fn ($query, $value) => 
            !in_array($value, $this->sortable) 
            ? $query : 
            $query->orderBy($value, $filters['order'] ?? 'DESC')
        );
    }
}
