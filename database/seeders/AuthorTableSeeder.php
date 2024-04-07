<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AuthorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('authors')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'affiliation' => $faker->company,
                'department' => $faker->word,
                'position' => $faker->word,
                'orcid_id' => $faker->uuid,
                'profile_picture' => 'https://via.placeholder.com/150',
                'biography' => $faker->sentence,
                'research_interests' => $faker->sentence
            ]);
        }
    }
}
