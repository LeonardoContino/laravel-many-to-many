<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Type;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $type_ids = Type::select('id')->pluck('id')->toArray();
        for($i = 0; $i < 5;  $i++){
            $project = new Project();

            $project->type_id = Arr::random($type_ids);

            $project->title = $faker->text(20);
            $project->content = $faker->paragraph(15, true);
            
            $project->slug = Str::slug($project->title,'-');
            $project->save();

        }
    }
}
