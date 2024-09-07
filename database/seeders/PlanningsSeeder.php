<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanningsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('plannings')->insert([
            // Planificaciones de Nutrición
            [
                'title' => 'Despierta el Gigante: Nutrición de Volumen',
                'description' => 'Transforma tu físico y despierta todo tu potencial con este plan alimenticio diseñado para aumentar tu masa muscular. Recetas deliciosas y estratégicamente equilibradas te acompañarán en el camino hacia una versión más fuerte y poderosa de ti mismo.',
                'synopsis' => 'Elige crecer con un plan de volumen adaptado a tus necesidades de ganancia muscular.',
                'price' => 30.000,
                'image_id' => null,
                'category_id' => 33, // Categoría "dietas de volumen"
                'professional_id' => 2, // Nutricionista profesional
                'created_at' => now()
            ],
            [
                'title' => 'Rendimiento Máximo: Plan Keto de Campeones',
                'description' => 'Acelera la quema de grasa y redefine tu rendimiento con una dieta cetogénica creada para optimizar cada gramo de energía. Ideal para quienes buscan un enfoque extremo, equilibrado y delicioso para mantener un estado de cetosis mientras dominan sus entrenamientos.',
                'synopsis' => 'Potencia tu quema de grasa y lleva tu cuerpo al límite con la dieta keto más avanzada.',
                'price' => 28.500,
                'image_id' => null,
                'category_id' => 31, // Categoría "nutrición keto"
                'professional_id' => 2, // Nutricionista profesional
                'created_at' => now()
            ],
        
            // Planificaciones de Preparación Física
            [
                'title' => 'Fuerza Descomunal: Powerlifting Elite',
                'description' => 'Siente el poder de mover montañas con este plan avanzado de powerlifting. Enfocado en los tres grandes levantamientos, este programa está diseñado para aumentar tu fuerza explosiva, mejorar tu técnica y llevar tus marcas personales a niveles que jamás imaginaste.',
                'synopsis' => 'Conviértete en leyenda del powerlifting y rompe todos los récords con este plan de élite.',
                'price' => 45.000,
                'image_id' => null,
                'category_id' => 1, // Categoría "powerlifting"
                'professional_id' => 1, // Entrenador personal
                'created_at' => now()
            ],
            [
                'title' => 'Atleta Completo: Funcional Total',
                'description' => 'Para aquellos que no se conforman con menos, este plan de entrenamiento funcional es un viaje hacia la máxima capacidad física. Mejora tu fuerza, agilidad y resistencia a través de ejercicios dinámicos diseñados para convertirte en un atleta completo.',
                'synopsis' => 'Optimiza tu rendimiento en todos los aspectos físicos con el entrenamiento funcional más completo.',
                'price' => 38.000,
                'image_id' => null,
                'category_id' => 40, // Categoría "entrenamiento funcional"
                'professional_id' => 1, // Entrenador personal
                'created_at' => now()
            ],
        
            // Planificaciones Terapéuticas
            [
                'title' => 'Terapia Cognitiva para Ansiedad',
                'description' => 'Programa terapéutico diseñado para reducir la ansiedad utilizando técnicas cognitivo-conductuales que mejoran el bienestar mental.',
                'synopsis' => 'Supera la ansiedad con este plan terapéutico basado en la terapia cognitiva-conductual.',
                'price' => 50.000,
                'image_id' => null,
                'category_id' => 37, // Categoría "terapia cognitiva"
                'professional_id' => 3, // Terapeuta profesional
                'created_at' => now()
            ],
            [
                'title' => 'Plan de Meditación Guiada',
                'description' => 'Este plan incluye sesiones de meditación guiada diseñadas para reducir el estrés y mejorar la concentración, ideal para quienes buscan equilibrio mental y emocional.',
                'synopsis' => 'Encuentra la calma interior con un programa de meditación guiada personalizado.',
                'price' => 10.000,
                'image_id' => null,
                'category_id' => 39, // Categoría "meditación"
                'professional_id' => 3, // Terapeuta profesional
                'created_at' => now()
            ],
        ]);
    }
}
