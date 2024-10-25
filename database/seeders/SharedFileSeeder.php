<?php

namespace Database\Seeders;

use App\Models\SharedFile;
use Illuminate\Database\Seeder;

class SharedFileSeeder extends Seeder
{
    public function run()
    {
        // Maak precies 200 gedeelde bestanden aan
        SharedFile::factory()->count(200)->create();
    }
}

