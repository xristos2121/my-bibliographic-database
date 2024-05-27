<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AuthorTableSeeder::class,
            CategoriesTableSeeder::class,
            KeywordTableSeeder::class,
            PublicationsTypesTableSeeder::class,
            PublisherTableSeeder::class,
            TagsTableSeeder::class,
            PublicationsTableSeeder::class,
        ]);
    }
}
