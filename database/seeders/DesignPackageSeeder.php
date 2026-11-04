<?php

namespace Database\Seeders;

use App\Models\DesignPackage;
use Illuminate\Database\Seeder;

class DesignPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'slug' => 'essential', 'name' => 'Essential', 'sort_order' => 1,
                'tagline' => 'For budget-conscious homeowners',
                'note' => 'Design fee based on proposed floor area. A practical starting point for homeowners who need essential architectural planning.',
                'pricing_type' => 'per_sqft', 'rate' => 45,
                'features' => ['Client consultation', 'Concept floor plan', 'Architectural floor plans', 'Front and side elevations',
                    'Basic 3D exterior views (2 views)', 'Council submission drawings', 'Door and window schedule', 'Area calculations'],
            ],
            [
                'slug' => 'premium-design', 'name' => 'Premium', 'sort_order' => 2, 'is_featured' => true,
                'tagline' => 'Enhanced design detail',
                'note' => 'Design fee based on proposed floor area. For clients seeking more detailed design development and visualisation, subject to agreed scope.',
                'pricing_type' => 'per_sqft', 'rate' => 60,
                'features' => ['Everything in Essential', 'Detailed architectural drawings', '3D exterior visualisation', 'Interior layout planning',
                    'Electrical layout drawings', 'Plumbing layout drawings', 'Roof layout drawings', 'Material recommendations', 'Quantity estimation summary'],
            ],
            [
                'slug' => 'signature-luxury', 'name' => 'Signature Luxury', 'sort_order' => 3,
                'tagline' => 'Bespoke planning solution',
                'note' => 'Final fee depends on the confirmed project estimate and scope. For custom luxury projects requiring a tailored design approach and comprehensive planning.',
                'pricing_type' => 'percent', 'rate' => 3,
                'features' => ['Everything in Premium', 'Architectural design consultation', 'Custom luxury concept development', 'Photorealistic 3D exterior renders',
                    'Interior 3D design', 'Landscape concept design', 'Full structural drawings', 'Detailed BOQ preparation', 'Elemental cost estimate',
                    'Construction planning support', 'Design revisions'],
            ],
        ];

        foreach ($packages as $data) {
            // Only create missing packages - never overwrite rates edited in the admin panel.
            DesignPackage::firstOrCreate(['slug' => $data['slug']], $data + ['construction_rate' => 16500]);
        }
    }
}
