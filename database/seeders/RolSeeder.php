<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'created_at' => now()
            ],
            [
                'name' => 'atlete',
                'created_at' => now()
            ],
            [
                'name' => 'professional',
                'created_at' => now()
            ],
        ]);
    }
}
