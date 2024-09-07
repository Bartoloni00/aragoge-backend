<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ["name" => "powerlifting", "created_at" => now()],
            ["name" => "crossfit", "created_at" => now()],
            ["name" => "maratón", "created_at" => now()],
            ["name" => "culturismo", "created_at" => now()],
            ["name" => "calistenia", "created_at" => now()],
            ["name" => "yoga", "created_at" => now()],
            ["name" => "natación", "created_at" => now()],
            ["name" => "fútbol", "created_at" => now()],
            ["name" => "baloncesto", "created_at" => now()],
            ["name" => "tenis", "created_at" => now()],
            ["name" => "ciclismo", "created_at" => now()],
            ["name" => "boxeo", "created_at" => now()],
            ["name" => "mma", "created_at" => now()],
            ["name" => "pesas", "created_at" => now()],
            ["name" => "halterofilia", "created_at" => now()],
            ["name" => "running", "created_at" => now()],
            ["name" => "triatlón", "created_at" => now()],
            ["name" => "escalada", "created_at" => now()],
            ["name" => "remo", "created_at" => now()],
            ["name" => "judo", "created_at" => now()],
            ["name" => "karate", "created_at" => now()],
            ["name" => "gimnasia", "created_at" => now()],
            ["name" => "pilates", "created_at" => now()],
            ["name" => "zumba", "created_at" => now()],
            ["name" => "aeróbicos", "created_at" => now()],
            ["name" => "kickboxing", "created_at" => now()],
            ["name" => "esgrima", "created_at" => now()],
            ["name" => "voleibol", "created_at" => now()],
            ["name" => "rugby", "created_at" => now()],
            ["name" => "parkour", "created_at" => now()],
            ["name" => "nutrición deportiva", "created_at" => now()],
            ["name" => "nutrición vegana", "created_at" => now()],
            ["name" => "nutrición keto", "created_at" => now()],
            ["name" => "dietas de volumen", "created_at" => now()],
            ["name" => "dietas de definición", "created_at" => now()],
            ["name" => "fisioterapia", "created_at" => now()],
            ["name" => "terapia cognitiva", "created_at" => now()],
            ["name" => "meditación", "created_at" => now()],
            ["name" => "respiración", "created_at" => now()],
            ["name" => "entrenamiento funcional", "created_at" => now()],
        ]);
    }
}
