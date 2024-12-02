<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payments')->insert([
            [
                'amount' => DB::table('plannings')->where('id', DB::table('subscriptions')->where('subscription_date', '2024-09-01')->value('planning_id'))->value('price'),
                'payment_date' => '2024-09-01',
                'playment_method' => 'Mercado Pago',
                'playment_status' => 'Success',
                'subscription_id' => DB::table('subscriptions')->where('subscription_date', '2024-09-01')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'amount' => DB::table('plannings')->where('id', DB::table('subscriptions')->where('subscription_date', '2024-08-15')->value('planning_id'))->value('price'),
                'payment_date' => '2024-08-15',
                'playment_method' => 'Mercado Pago',
                'playment_status' => 'Success',
                'subscription_id' => DB::table('subscriptions')->where('subscription_date', '2024-08-15')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'amount' => DB::table('plannings')->where('id', DB::table('subscriptions')->where('subscription_date', '2024-09-05')->value('planning_id'))->value('price'),
                'payment_date' => '2024-09-05',
                'playment_method' => 'Mercado Pago',
                'playment_status' => 'Success',
                'subscription_id' => DB::table('subscriptions')->where('subscription_date', '2024-09-05')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'amount' => DB::table('plannings')->where('id', DB::table('subscriptions')->where('subscription_date', '2024-08-20')->value('planning_id'))->value('price'),
                'payment_date' => '2024-08-20',
                'playment_method' => 'Mercado Pago',
                'playment_status' => 'Success',
                'subscription_id' => DB::table('subscriptions')->where('subscription_date', '2024-08-20')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'amount' => DB::table('plannings')->where('id', DB::table('subscriptions')->where('subscription_date', '2024-09-01')->value('planning_id'))->value('price'),
                'payment_date' => '2024-09-01',
                'playment_method' => 'Mercado Pago',
                'playment_status' => 'Success',
                'subscription_id' => DB::table('subscriptions')->where('subscription_date', '2024-09-01')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'amount' => DB::table('plannings')->where('id', DB::table('subscriptions')->where('subscription_date', '2024-08-15')->value('planning_id'))->value('price'),
                'payment_date' => '2024-08-15',
                'playment_method' => 'Mercado Pago',
                'playment_status' => 'Success',
                'subscription_id' => DB::table('subscriptions')->where('subscription_date', '2024-08-15')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'amount' => DB::table('plannings')->where('id', DB::table('subscriptions')->where('subscription_date', '2024-09-05')->value('planning_id'))->value('price'),
                'payment_date' => '2024-09-05',
                'playment_method' => 'Mercado Pago',
                'playment_status' => 'Success',
                'subscription_id' => DB::table('subscriptions')->where('subscription_date', '2024-09-05')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'amount' => DB::table('plannings')->where('id', DB::table('subscriptions')->where('subscription_date', '2024-08-20')->value('planning_id'))->value('price'),
                'payment_date' => '2024-08-20',
                'playment_method' => 'Mercado Pago',
                'playment_status' => 'Success',
                'subscription_id' => DB::table('subscriptions')->where('subscription_date', '2024-08-20')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
        
    }
}
