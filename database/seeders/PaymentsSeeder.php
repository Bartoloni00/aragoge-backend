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
                'total_price' => DB::table('plannings')->where('id', DB::table('subscriptions')->where('subscription_date', '2024-09-01')->value('planning_id'))->value('price'),
                'preference_id' => '533583724-24e54b93-d1bd-4319-8ec5-75b37c2a4cbf',
                'payment_id' => '1316725408',
                'payment_status' => 'Success',
                'subscription_id' => DB::table('subscriptions')->where('subscription_date', '2024-09-01')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'total_price' => DB::table('plannings')->where('id', DB::table('subscriptions')->where('subscription_date', '2024-08-15')->value('planning_id'))->value('price'),
                'preference_id' => '533583724-24e54b93-d1bd-4319-8ec5-75b37c2a4cbf',
                'payment_id' => '1316725408',
                'payment_status' => 'Success',
                'subscription_id' => DB::table('subscriptions')->where('subscription_date', '2024-08-15')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'total_price' => DB::table('plannings')->where('id', DB::table('subscriptions')->where('subscription_date', '2024-09-05')->value('planning_id'))->value('price'),
                'preference_id' => '533583724-24e54b93-d1bd-4319-8ec5-75b37c2a4cbf',
                'payment_id' => '1316725408',
                'payment_status' => 'Success',
                'subscription_id' => DB::table('subscriptions')->where('subscription_date', '2024-09-05')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'total_price' => DB::table('plannings')->where('id', DB::table('subscriptions')->where('subscription_date', '2024-08-20')->value('planning_id'))->value('price'),
                'preference_id' => '533583724-24e54b93-d1bd-4319-8ec5-75b37c2a4cbf',
                'payment_id' => '1316725408',
                'payment_status' => 'Success',
                'subscription_id' => DB::table('subscriptions')->where('subscription_date', '2024-08-20')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'total_price' => DB::table('plannings')->where('id', DB::table('subscriptions')->where('subscription_date', '2024-09-01')->value('planning_id'))->value('price'),
                'preference_id' => '533583724-24e54b93-d1bd-4319-8ec5-75b37c2a4cbf',
                'payment_id' => '1316725408',
                'payment_status' => 'Success',
                'subscription_id' => DB::table('subscriptions')->where('subscription_date', '2024-09-01')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'total_price' => DB::table('plannings')->where('id', DB::table('subscriptions')->where('subscription_date', '2024-08-15')->value('planning_id'))->value('price'),
                'preference_id' => '533583724-24e54b93-d1bd-4319-8ec5-75b37c2a4cbf',
                'payment_id' => '1316725408',
                'payment_status' => 'Success',
                'subscription_id' => DB::table('subscriptions')->where('subscription_date', '2024-08-15')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'total_price' => DB::table('plannings')->where('id', DB::table('subscriptions')->where('subscription_date', '2024-09-05')->value('planning_id'))->value('price'),
                'preference_id' => '533583724-24e54b93-d1bd-4319-8ec5-75b37c2a4cbf',
                'payment_id' => '1316725408',
                'payment_status' => 'Success',
                'subscription_id' => DB::table('subscriptions')->where('subscription_date', '2024-09-05')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'total_price' => DB::table('plannings')->where('id', DB::table('subscriptions')->where('subscription_date', '2024-08-20')->value('planning_id'))->value('price'),
                'preference_id' => '533583724-24e54b93-d1bd-4319-8ec5-75b37c2a4cbf',
                'payment_id' => '1316725408',
                'payment_status' => 'Success',
                'subscription_id' => DB::table('subscriptions')->where('subscription_date', '2024-08-20')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
        
    }
}
