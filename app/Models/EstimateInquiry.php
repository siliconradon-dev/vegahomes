<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstimateInquiry extends Model
{
    protected $fillable = [
        'reference', 'package_slug', 'package_name', 'rate', 'is_starting_rate',
        'floors', 'district', 'town_area', 'design_status', 'approval_status',
        'ground_area', 'first_area', 'second_area', 'total_area', 'estimated_cost', 'rooms',
        'name', 'phone', 'email', 'land_ownership', 'start_date', 'comments',
        'status', 'admin_notes', 'contacted_at', 'ip',
    ];

    protected $casts = [
        'rate'             => 'integer',
        'is_starting_rate' => 'boolean',
        'floors'           => 'integer',
        'ground_area'      => 'float',
        'first_area'       => 'float',
        'second_area'      => 'float',
        'total_area'       => 'float',
        'estimated_cost'   => 'integer',
        'rooms'            => 'array',
        'start_date'       => 'date',
        'contacted_at'     => 'datetime',
    ];

    public function attachments(): HasMany
    {
        return $this->hasMany(EstimateAttachment::class);
    }

    public function getHouseTypeAttribute(): string
    {
        return match ((int) $this->floors) {
            1 => 'Single-Storey',
            2 => 'Two-Storey',
            default => 'Three-Storey',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return config('vega.inquiry_statuses.' . $this->status, ucfirst((string) $this->status));
    }

    public function getCostLabelAttribute(): string
    {
        return ($this->is_starting_rate ? 'From ' : '') . 'LKR ' . number_format($this->estimated_cost);
    }

    /** Client's phone converted to WhatsApp international format (Sri Lanka default). */
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

    /** Link the admin clicks to chat with the client. */
    public function getClientWhatsappUrlAttribute(): ?string
    {
        $number = $this->client_whatsapp_number;
        if (!$number) {
            return null;
        }
        $text = "Hello {$this->name}, this is Vega Homes (Pvt) Ltd regarding your enquiry {$this->reference}. ";
        return 'https://wa.me/' . $number . '?text=' . rawurlencode($text);
    }

    /** Pre-filled WhatsApp message sent from the visitor to the company number. */
    public function whatsappMessage(): string
    {
        $lines = [
            "*New Home Estimate Enquiry*",
            "Ref: {$this->reference}",
            "",
            "*Package:* {$this->package_name} (" . ($this->is_starting_rate ? 'from ' : '') . 'LKR ' . number_format($this->rate) . ' / sq.ft.)',
            "*House:* {$this->house_type}, " . rtrim(rtrim(number_format($this->total_area, 2), '0'), '.') . ' sq.ft.',
            "*Estimate:* {$this->cost_label}",
            "*Location:* {$this->town_area}, {$this->district}",
            "*Design:* {$this->design_status}",
            "*Plan approval:* {$this->approval_status}",
        ];

        if ($this->start_date) {
            $lines[] = '*Start:* ' . $this->start_date->format('d M Y');
        }

        $lines[] = '';
        $lines[] = "*Name:* {$this->name}";
        $lines[] = "*Phone:* {$this->phone}";
        if ($this->email) {
            $lines[] = "*Email:* {$this->email}";
        }
        if ($this->comments) {
            $lines[] = "*Notes:* " . \Illuminate\Support\Str::limit($this->comments, 300);
        }

        return implode("\n", $lines);
    }

    public function whatsappUrl(): string
    {
        return 'https://wa.me/' . config('vega.whatsapp_number') . '?text=' . rawurlencode($this->whatsappMessage());
    }
}
