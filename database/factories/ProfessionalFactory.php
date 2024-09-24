<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Professional;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Professional>
 */
class ProfessionalFactory extends Factory
{

    protected $model = Professional::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->paragraph(3), 
            'synopsis' => $this->faker->sentence(10),
            'specialty_id' => $this->faker->randomElement([1, 2, 3]), // 1=Entrenador, 2=Nutricionista, 3=Terapeuta
        ];
    }
}
