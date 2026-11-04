<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Imports the 3D designs that were hard-coded on the old projects page
     * (images already exist in public/images/projects/<folder>/<n>.jpg).
     * Only runs once - it never touches projects you add or edit in the admin panel.
     */
    public function run(): void
    {
        if (Project::exists()) {
            return;
        }

        $legacy = [
            ['789', 14, 'VH-789'], ['790', 14, 'VH-790'], ['791', 14, 'VH-791'], ['792', 12, 'VH-792'],
            ['793', 14, 'VH-793'], ['794', 12, 'VH-794'], ['795-1', 14, 'VH-795 (Exterior)'], ['795-2', 44, 'VH-795 (Interior)'],
        ];

        foreach ($legacy as $i => [$folder, $count, $title]) {
            $images = [];
            for ($n = 1; $n <= $count; $n++) {
                $images[] = "images/projects/{$folder}/{$n}.jpg";
            }

            Project::create([
                'title'        => $title,
                'slug'         => Project::uniqueSlug($title),
                'status'       => 'design',
                'images'       => $images,
                'is_published' => true,
                'sort_order'   => 100 + $i,
            ]);
        }
    }
}
