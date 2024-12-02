<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subscriptions')->insert([
            [
                'subscription_date' => '2024-09-01',
                'expiration_date' => date('Y-m-d', strtotime('2024-09-01 + 30 days')),
                'is_active' => now() < date('Y-m-d', strtotime('2024-09-01 + 30 days')) ? true : false,
                'planning_id' => rand(1, 6), // Aleatorio entre 1 y 6
                'user_id' => rand(6, 8), // Aleatorio entre 6, 7 u 8
                'created_at' => now()
            ],
            [
                'subscription_date' => '2024-08-15',
                'expiration_date' => date('Y-m-d', strtotime('2024-08-15 + 30 days')),
                'is_active' => now() < date('Y-m-d', strtotime('2024-08-15 + 30 days')) ? true : false,
                'planning_id' => rand(1, 6),
                'user_id' => rand(6, 8),
                'created_at' => now()
            ],
            [
                'subscription_date' => '2024-09-05',
                'expiration_date' => date('Y-m-d', strtotime('2024-09-05 + 30 days')),
                'is_active' => now() < date('Y-m-d', strtotime('2024-09-05 + 30 days')) ? true : false,
                'planning_id' => rand(1, 6),
                'user_id' => rand(6, 8),
                'created_at' => now()
            ],
            [
                'subscription_date' => '2024-08-20',
                'expiration_date' => date('Y-m-d', strtotime('2024-08-20 + 30 days')),
                'is_active' => now() < date('Y-m-d', strtotime('2024-08-20 + 30 days')) ? true : false,
                'planning_id' => rand(1, 6),
                'user_id' => rand(6, 8),
                'created_at' => now()
            ],
            [
                'subscription_date' => '2024-09-01',
                'expiration_date' => date('Y-m-d', strtotime('2024-09-01 + 30 days')),
                'is_active' => now() < date('Y-m-d', strtotime('2024-09-01 + 30 days')) ? true : false,
                'planning_id' => rand(1, 6), // Aleatorio entre 1 y 6
                'user_id' => rand(6, 8), // Aleatorio entre 6, 7 u 8
                'created_at' => now()
            ],
            [
                'subscription_date' => '2024-08-15',
                'expiration_date' => date('Y-m-d', strtotime('2024-08-15 + 30 days')),
                'is_active' => now() < date('Y-m-d', strtotime('2024-08-15 + 30 days')) ? true : false,
                'planning_id' => rand(1, 6),
                'user_id' => rand(6, 8),
                'created_at' => now()
            ],
            [
                'subscription_date' => '2024-09-05',
                'expiration_date' => date('Y-m-d', strtotime('2024-09-05 + 30 days')),
                'is_active' => now() < date('Y-m-d', strtotime('2024-09-05 + 30 days')) ? true : false,
                'planning_id' => rand(1, 6),
                'user_id' => rand(6, 8),
                'created_at' => now()
            ],
            [
                'subscription_date' => '2024-08-20',
                'expiration_date' => date('Y-m-d', strtotime('2024-08-20 + 30 days')),
                'is_active' => now() < date('Y-m-d', strtotime('2024-08-20 + 30 days')) ? true : false,
                'planning_id' => rand(1, 6),
                'user_id' => rand(6, 8),
                'created_at' => now()
            ]
        ]);
    }
}
