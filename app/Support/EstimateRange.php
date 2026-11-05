<?php

namespace App\Support;

/**
 * Turns an exact estimate into a rounded, slightly asymmetric range so the real
 * per-sq.ft. / percentage rates cannot be worked out by competitors from the website.
 * (The admin panel always keeps and shows the exact figure.)
 */
class EstimateRange
{
    public static function enabled(): bool
    {
        return (bool) config('vega.show_estimates', true);
    }

    /** @return array{low: int, high: int, label: string} */
    public static function make(int $amount): array
    {
        $lowFactor  = (float) config('vega.estimate_range_low', 0.88);
        $highFactor = (float) config('vega.estimate_range_high', 1.17);

        $digits = strlen((string) max($amount, 1));
        $step   = (int) pow(10, max($digits - 2, 1)); // keep 2 significant digits

        $low  = (int) (floor(($amount * $lowFactor) / $step) * $step);
        $high = (int) (ceil(($amount * $highFactor) / $step) * $step);

        return [
            'low'   => $low,
            'high'  => $high,
            'label' => 'LKR ' . number_format($low) . ' – ' . number_format($high),
        ];
    }

    public static function label(int $amount): ?string
    {
        return self::enabled() ? self::make($amount)['label'] : null;
    }
}
