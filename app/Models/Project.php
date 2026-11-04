<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    public const STATUSES = [
        'ongoing'   => 'Ongoing',
        'completed' => 'Completed',
        'design'    => '3D Design',
    ];

    /** Uploaded images live here (relative to /public). Seeded legacy images live in images/projects. */
    public const UPLOAD_DIR = 'uploads/projects';

    protected $fillable = [
        'title', 'slug', 'status', 'location', 'description', 'progress',
        'started_on', 'completed_on', 'images', 'is_published', 'sort_order',
    ];

    protected $casts = [
        'progress'     => 'integer',
        'started_on'   => 'date',
        'completed_on' => 'date',
        'images'       => 'array',
        'is_published' => 'boolean',
        'sort_order'   => 'integer',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderByDesc('id');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst((string) $this->status);
    }

    /** @return array<int, string> full URLs of every image */
    public function getImageUrlsAttribute(): array
    {
        return collect($this->images ?? [])->map(fn ($p) => asset($p))->values()->all();
    }

    public function getCoverUrlAttribute(): ?string
    {
        $first = ($this->images ?? [])[0] ?? null;

        return $first ? asset($first) : null;
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'project';
        $slug = $base;
        $i    = 2;

        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
