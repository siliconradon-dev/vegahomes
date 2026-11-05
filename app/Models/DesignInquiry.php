<?php

namespace App\Models;

use App\Support\EstimateRange;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DesignInquiry extends Model
{
    protected $fillable = [
        'reference', 'package_slug', 'package_name', 'pricing_type', 'rate', 'construction_rate',
        'area', 'house_type', 'district', 'construction_estimate', 'design_fee', 'calculation_basis', 'addons',
        'name', 'phone', 'email', 'start_date', 'comments',
        'status', 'admin_notes', 'contacted_at', 'ip',
    ];

    protected $casts = [
        'rate'                  => 'float',
        'construction_rate'     => 'integer',
        'area'                  => 'float',
        'construction_estimate' => 'integer',
        'design_fee'            => 'integer',
        'addons'                => 'array',
        'start_date'            => 'date',
        'contacted_at'          => 'datetime',
    ];

    public function getStatusLabelAttribute(): string
    {
        return config('vega.inquiry_statuses.' . $this->status, ucfirst((string) $this->status));
    }

    public function getFeeLabelAttribute(): string
    {
        return 'LKR ' . number_format($this->design_fee);
    }

    public function getFeeRangeLabelAttribute(): ?string
    {
        return EstimateRange::label((int) $this->design_fee);
    }

    public function getAreaLabelAttribute(): string
    {
        return rtrim(rtrim(number_format($this->area, 2), '0'), '.') . ' sq.ft.';
    }

    public function getAddonTitlesAttribute(): array
    {
        $all = config('vega.design_addons');

        return collect($this->addons ?? [])
            ->map(fn ($slug) => $all[$slug][0] ?? $slug)
            ->values()
            ->all();
    }

    public function getClientWhatsappNumberAttribute(): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $this->phone);
        if ($digits === '' || $digits === null) {
            return null;
        }
        if (str_starts_with($digits, '00')) {
            $digits = substr($digits, 2);
        }
        if (str_starts_with($digits, '0')) {
            return '94' . substr($digits, 1);
        }
        if (strlen($digits) === 9) {
            return '94' . $digits;
        }
        return $digits;
    }

    public function getClientWhatsappUrlAttribute(): ?string
    {
        $number = $this->client_whatsapp_number;
        if (!$number) {
            return null;
        }
        $text = "Hello {$this->name}, this is Vega Homes (Pvt) Ltd regarding your design enquiry {$this->reference}. ";
        return 'https://wa.me/' . $number . '?text=' . rawurlencode($text);
    }

    public function whatsappMessage(): string
    {
        $rates = (bool) config('vega.public_rates');

        $lines = [
            '*New Architectural Design Enquiry*',
            "Ref: {$this->reference}",
            '',
            "*Package:* {$this->package_name}",
        ];

        if ($rates) {
            $lines[] = "*Calculation:* {$this->calculation_basis}";
            $lines[] = "*Design fee (indicative):* {$this->fee_label}";
        } elseif ($this->fee_range_label) {
            $lines[] = "*Design fee range:* {$this->fee_range_label}";
        }

        $lines[] = "*Floor area:* {$this->area_label} ({$this->house_type})";

        if ($rates) {
            $lines[] = '*Construction estimate:* LKR ' . number_format($this->construction_estimate);
        }

        if ($this->district) {
            $lines[] = "*District:* {$this->district}";
        }
        if (!empty($this->addon_titles)) {
            $lines[] = '*Add-ons:* ' . implode(', ', $this->addon_titles);
        }
        if ($this->start_date) {
            $lines[] = '*Design start:* ' . $this->start_date->format('d M Y');
        }

        $lines[] = '';
        $lines[] = "*Name:* {$this->name}";
        $lines[] = "*Phone:* {$this->phone}";
        if ($this->email) {
            $lines[] = "*Email:* {$this->email}";
        }
        if ($this->comments) {
            $lines[] = '*Notes:* ' . Str::limit($this->comments, 300);
        }

        return implode("\n", $lines);
    }

    public function whatsappUrl(): string
    {
        return 'https://wa.me/' . config('vega.whatsapp_number') . '?text=' . rawurlencode($this->whatsappMessage());
    }
}
