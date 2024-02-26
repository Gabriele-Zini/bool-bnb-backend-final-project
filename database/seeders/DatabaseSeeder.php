<?php

namespace Database\Seeders;

use App\Models\Apartment_info;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UsersTableSeeder::class,
            ServicesTableSeeder::class,
            SponsorshipsTableSeeder::class,
            ApartmentsTableSeeder::class,
            MessagesTableSeeder::class,
            ViewsTableSeeder::class,
            Apartment_infoTableSeeder::class,
            ApartmentSponsorshipsSeeder::class
        ]);
    }
}
