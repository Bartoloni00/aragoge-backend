<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Planning;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolSeeder::class);
        $this->call(SpecialtySeeder::class);
        // $this->call(ImageSeeder::class);
        $this->call(ProfessionalSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(PlanningsSeeder::class);
        $this->call(SubscriptionsSeeder::class);
        $this->call(PaymentsSeeder::class);

        User::factory(50)->create();
        Planning::factory(150)->create();
    }
}
