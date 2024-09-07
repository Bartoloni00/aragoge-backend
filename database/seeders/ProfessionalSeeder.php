<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('professionals')->insert([
            [
                'description' => 'Entrenador personal especializado en fuerza y acondicionamiento físico. Con amplia experiencia en diseño de programas de entrenamiento personalizados.',
                'synopsis' => 'Ayudo a mis clientes a alcanzar sus objetivos de fitness de manera segura y efectiva. Mi enfoque se basa en la motivación y el seguimiento personalizado.',
                'specialty_id' => 1
            ],
            [
                'description' => 'Nutricionista deportiva especializada en nutrición para atletas de alto rendimiento. Elaboro planes alimentarios personalizados para optimizar el rendimiento y la recuperación.',
                'synopsis' => 'Mi pasión es ayudar a los deportistas a alcanzar su máximo potencial a través de una alimentación equilibrada y adecuada.',
                'specialty_id' => 2,
            ],
            [
                'description' => 'Terapeuta especializado en trastornos de ansiedad y estrés. Utilizo técnicas cognitivo-conductuales para ayudar a mis pacientes a desarrollar habilidades de afrontamiento y mejorar su calidad de vida.',
                'synopsis' => 'Creo en el poder de la mente para superar los desafíos. Mi objetivo es brindar un espacio seguro y confidencial para que mis pacientes puedan sanar y crecer.',
                'specialty_id' => 3,
            ]
        ]);
    }
}
