<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'slug' => 'standard', 'name' => 'Standard', 'rate' => 8800, 'sort_order' => 1,
                'tagline' => 'Practical specifications and essential finishes for everyday living.',
                'features' => ['Practical specifications', 'Essential finishes', 'Built for everyday living', 'Instant indicative estimate'],
            ],
            [
                'slug' => 'premium', 'name' => 'Premium', 'rate' => 11000, 'sort_order' => 2, 'is_featured' => true,
                'tagline' => 'Enhanced finishes, fittings and design details.',
                'features' => ['Enhanced finishes', 'Upgraded fittings', 'Refined design details', 'Instant indicative estimate'],
            ],
            [
                'slug' => 'luxury', 'name' => 'Luxury', 'rate' => 16500, 'sort_order' => 3,
                'tagline' => 'High-quality materials, refined finishes and upgraded features.',
                'features' => ['High-quality materials', 'Refined finishes', 'Upgraded features', 'Instant indicative estimate'],
            ],
            [
                'slug' => 'signature', 'name' => 'Signature', 'rate' => 22000, 'sort_order' => 4, 'is_starting_rate' => true,
                'tagline' => 'Tailored specifications and a more personalized design approach.',
                'features' => ['Tailored specifications', 'Personalized design approach', 'Starting rate – final price on scope', 'Instant indicative estimate'],
            ],
        ];

        foreach ($packages as $data) {
            // Only create missing packages - never overwrite rates the admin has edited.
            Package::firstOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
