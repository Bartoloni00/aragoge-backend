<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('specialties')->insert([
            [
                'name' => 'Entrenador',
                'created_at' => now()
            ],
            [
                'name' => 'Nutricionista',
                'created_at' => now()
            ],
            [
                'name' => 'Terapeuta',
                'created_at' => now()
            ],
            [
                'name' => 'Sin definir',
                'created_at' => now()
            ],
        ]);
    }
}
