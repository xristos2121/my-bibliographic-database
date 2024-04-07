<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Type;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Support\Facades\DB;


class PublicationsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('publications')->insert([
                'title' => $faker->sentence,
                'abstract' => $faker->paragraph,
                'publication_date' => $faker->date,
                // Assuming you want to store just a file name or path as a string
                'file' => 'path/to/file/' . $faker->word . '.pdf'
            ]);
        }
    }
}
