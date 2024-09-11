<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'first_name' => 'Abraham',
                'last_name' => 'Bartoloni',
                'email' => 'bartoloniabraham@gmail.com',
                'password' => Hash::make('Asd1234'),
                'image_id' => null,
                'rol_id' => 1,
                'professional_id' => null,
                'created_at' => now()
            ],
            [
                'first_name' => 'Ezequiel',
                'last_name' => 'Arevalo',
                'email' => 'arevaloezequiel@gmail.com',
                'password' => Hash::make('Asd1234'),
                'image' => null,
                'rol_id' => 1,
                'professional_id' => null,
                'created_at' => now()
            ],
            [
                'first_name' => 'Diego',
                'last_name' => 'Herrera',
                'email' => 'herreradiego@gmail.com',
                'password' => Hash::make('Asd1234'),
                'image' => null,
                'rol_id' => 3,
                'professional_id' => 1,
                'created_at' => now()
            ],
            [
                'first_name' => 'Valeria',
                'last_name' => 'Lopez',
                'email' => 'lopezvaleria@gmail.com',
                'password' => Hash::make('Asd1234'),
                'image' => null,
                'rol_id' => 3,
                'professional_id' => 2,
                'created_at' => now()
            ],
            [
                'first_name' => 'Santiago',
                'last_name' => 'Morales',
                'email' => 'moralessantiago@gmail.com',
                'password' => Hash::make('Asd1234'),
                'image' => null,
                'rol_id' => 3,
                'professional_id' => 3,
                'created_at' => now()
            ],
            [
                'first_name' => 'Lucas',
                'last_name' => 'Mendez',
                'email' => 'mendezlucas@gmail.com',
                'password' => Hash::make('Asd1234'),
                'image' => null,
                'rol_id' => 2,
                'professional_id' => null,
                'created_at' => now()
            ],
            [
                'first_name' => 'Camila',
                'last_name' => 'Torres',
                'email' => 'torrescamila@gmail.com',
                'password' => Hash::make('Asd1234'),
                'image' => null,
                'rol_id' => 2,
                'professional_id' => null,
                'created_at' => now()
            ],
            [
                'first_name' => 'Nicolas',
                'last_name' => 'Fernandez',
                'email' => 'fernandeznicolas@gmail.com',
                'password' => Hash::make('Asd1234'),
                'image' => null,
                'rol_id' => 2,
                'professional_id' => null,
                'created_at' => now()
            ],
        ]);
    }
}
