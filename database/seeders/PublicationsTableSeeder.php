<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Type;
use App\Models\Collection;
use App\Models\Publisher;
use Illuminate\Support\Facades\DB;


class PublicationsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            $publicationDate = $faker->date('Y-m-d');


            DB::table('publications')->insert([
                'title' => $faker->sentence,
                'abstract' => $faker->paragraph,
                'publication_date' => $publicationDate,
                'type_id' => Type::inRandomOrder()->first()->id,
                'file' => 'publications/' . $faker->word . '.pdf',
                'slug' => $faker->slug,
            ]);
        }
    }
}
