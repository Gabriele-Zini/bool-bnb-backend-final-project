<?php

namespace Database\Seeders;

use App\Models\Sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $sponsorships = [
            ['name' => 'light sponsorization', 
            'duration' => 24,
            'price' => 2,99],

            ['name' => 'premium sponsorization', 
            'duration' => 72,
            'price' => 5,99],

            ['name' => 'gold sponsorization', 
            'duration' => 144,
            'price' => 9,99]

        ];

        foreach ($sponsorships as $sponsorship){

            
            $new_sponsorship = new Sponsorship();
            $new_sponsorship->price = $sponsorship['price'];
            $new_sponsorship->duration = $sponsorship['duration'];
            $new_sponsorship->name = $sponsorship['name'];

            $new_sponsorship->save();
        }
    }
}
