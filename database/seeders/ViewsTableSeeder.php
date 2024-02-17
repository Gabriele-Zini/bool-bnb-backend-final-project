<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\View;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ViewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        

        for ($i=0; $i < 10; $i++) { 
            
            $newViews = new View();
            $newViews->apartment_id = Apartment::all()->random()->id;
             
            $newViews->user_ip=$faker->ipv4();

            $newViews->save();
        }

    }
}
