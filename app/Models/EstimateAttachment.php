<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EstimateAttachment extends Model
{
    protected $fillable = ['estimate_inquiry_id', 'original_name', 'path', 'mime', 'size'];

    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(EstimateInquiry::class, 'estimate_inquiry_id');
    }

    public function getHumanSizeAttribute(): string
    {
        $bytes = (int) $this->size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }
        return number_format(max($bytes, 1) / 1024, 0) . ' KB';
    }
}
