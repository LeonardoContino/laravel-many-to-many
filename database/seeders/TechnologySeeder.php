<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Technology;


class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $technologies = [
                ['label' => 'HTML', 'color' => '#ff0000'],
                ['label' => 'CSS', 'color' => '#0000ff'],
                ['label' => 'JAVASCRIPT', 'color' => '#EFD81D'],
                ['label' => 'VUE', 'color' => '#00ff00'],
                ['label' => 'BOOTSTRAP', 'color' => '#7300FF'],
                ['label' => 'SASS', 'color' => '#EE63B4'],
                ['label' => 'PHP', 'color' => '#007BFF'],
                ['label' => 'LARAVEL', 'color' => '#7E0707'],
            ];

        foreach ($technologies as $tech) {
            $technology = new Technology();
            $technology->label = $tech['label'];
            $technology->color = $tech['color'];
            $technology->save();
        }
    }
}
