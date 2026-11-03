<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'slug', 'name', 'tagline', 'rate', 'is_starting_rate',
        'is_featured', 'is_active', 'sort_order', 'features',
    ];

    protected $casts = [
        'rate'             => 'integer',
        'is_starting_rate' => 'boolean',
        'is_featured'      => 'boolean',
        'is_active'        => 'boolean',
        'sort_order'       => 'integer',
        'features'         => 'array',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    public function getRateLabelAttribute(): string
    {
        return ($this->is_starting_rate ? 'From ' : '') . 'LKR ' . number_format($this->rate);
    }
}
