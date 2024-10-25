<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\File;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Roep de UserSeeder aan om 100 gebruikers aan te maken
        $this->call(UserSeeder::class);
        $this->call(FileSeeder::class);
        $this->call(SharedFileSeeder::class);   
    }
}

