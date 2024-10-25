<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\User; // Zorg ervoor dat je het User model importeert
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    protected $model = File::class;

    public function definition()
    {
        // Definieer de mogelijke extensies
        $extensions = ['png', 'jpeg', 'jpg'];

        return [
            'user_id' => User::factory(), // Verbindt het bestand met een willekeurige gebruiker
            'filename' => $this->faker->word() . '.' . $this->faker->randomElement($extensions), // Genereer een willekeurige bestandsnaam met extensie
            'path' => $this->faker->filePath(), // Genereer een willekeurig pad
        ];
    }
}  

