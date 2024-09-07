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
                'name' => 'trainer',
                'created_at' => now()
            ],
            [
                'name' => 'nutritionist',
                'created_at' => now()
            ],
            [
                'name' => 'therapist',
                'created_at' => now()
            ],
        ]);
    }
}
