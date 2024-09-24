<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Planning;
use App\Models\Professional;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Planning>
 */
class PlanningFactory extends Factory
{

    protected $model = Planning::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6), // Título con 6 palabras aleatorias
            'description' => $this->faker->paragraph(5), // Descripción con 5 oraciones
            'synopsis' => $this->faker->sentence(10), // Sinopsis con 10 palabras
            'price' => $this->faker->randomFloat(2, 10000, 50000),
            'image_id' => null, // Siempre será null
            'category_id' => Category::inRandomOrder()->first()->id,
            'professional_id' => Professional::inRandomOrder()->first()->id, // Asignar un professional aleatorio
            'created_at' => now(),
        ];
    }
}
