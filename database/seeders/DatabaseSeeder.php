<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Tag::findOrCreate(
            values: [
                'Development',
                'Staging',
                'QA',
                'Production',
            ],
            type: 'application_environments',
        );
    }
}
