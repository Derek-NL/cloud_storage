<?php

namespace Database\Seeders;

use App\Models\File;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    public function run()
    {
        // Maak precies 500 bestanden aan
        File::factory()->count(500)->create();
    }
}
