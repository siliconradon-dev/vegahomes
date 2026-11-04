<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DesignPackage extends Model
{
    public const PER_SQFT = 'per_sqft';
    public const PERCENT  = 'percent';

    protected $fillable = [
        'slug', 'name', 'tagline', 'note', 'pricing_type', 'rate', 'construction_rate',
        'is_featured', 'is_active', 'sort_order', 'features',
    ];

    protected $casts = [
        'rate'              => 'float',
        'construction_rate' => 'integer',
        'is_featured'       => 'boolean',
        'is_active'         => 'boolean',
        'sort_order'        => 'integer',
        'features'          => 'array',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    public function isPercent(): bool
    {
        return $this->pricing_type === self::PERCENT;
    }

    /** "45" or "3" - no trailing zeros. */
    public function getRatePlainAttribute(): string
    {
        return rtrim(rtrim(number_format($this->rate, 2, '.', ''), '0'), '.');
    }

    /** Big price shown on the card. */
    public function getRateLabelAttribute(): string
    {
        return $this->isPercent()
            ? $this->rate_plain . '% of construction estimate'
            : 'LKR ' . number_format($this->rate, $this->rate == floor($this->rate) ? 0 : 2) . ' / sq.ft.';
    }

    /**
     * Server-side fee calculation (the browser only previews it).
     *
     * @return array{construction: int, fee: int, basis: string}
     */
    public function calculate(float $area): array
    {
        $construction = $area * $this->construction_rate;

        if ($this->isPercent()) {
            $fee   = $construction * $this->rate / 100;
            $basis = $this->rate_plain . '% × LKR ' . number_format(round($construction));
        } else {
            $fee   = $area * $this->rate;
            $basis = rtrim(rtrim(number_format($area, 2), '0'), '.') . ' × LKR ' . $this->rate_plain;
        }

        return [
            'construction' => (int) round($construction),
            'fee'          => (int) round($fee),
            'basis'        => $basis,
        ];
    }
}
