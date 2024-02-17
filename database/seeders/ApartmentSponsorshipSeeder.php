<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Carbon\Carbon;

class ApartmentSponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsorships = Sponsorship::all();
        $apartments = Apartment::all();

        foreach ($apartments as $apartment) {
            $randomSponsorship = $sponsorships->random();
            $startDate = Carbon::now()->subDays(rand(0, 30));
            $expirationDate = $startDate->addDays($randomSponsorship->duration / 24);

            $apartment->sponsorships()->attach($randomSponsorship, [
                'start_date' => $startDate,
                'expiration_date' => $expirationDate,
            ]);
        }
    }
}
