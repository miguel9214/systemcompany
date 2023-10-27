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
        \App\Models\Dependencie::factory(6)->create();
        \App\Models\Computer::factory(25)->create();
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
