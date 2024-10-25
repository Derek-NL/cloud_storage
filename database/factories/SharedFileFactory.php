<?php

namespace Database\Factories;

use App\Models\SharedFile;
use App\Models\File;
use App\Models\User; 
use Illuminate\Database\Eloquent\Factories\Factory;

class SharedFileFactory extends Factory
{
    protected $model = SharedFile::class;

    public function definition()
    {
        return [
            'file_id' => File::factory(), // Koppel het gedeelde bestand aan een willekeurig bestand
            'user_id' => User::factory(), // Koppel de gebruiker aan een willekeurige gebruiker
            'email' => $this->faker->unique()->safeEmail(), // Genereer een unieke e-mail
            'shared_by' => User::factory(), // Koppel de 'shared_by' aan een willekeurige gebruiker
        ];
    }
}                   