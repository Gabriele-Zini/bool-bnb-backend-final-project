<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Apartment_info;
use App\Models\Sponsorship;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $services = Service::all();
        $apartmentsData = config('apartments');

        foreach ($apartmentsData as $data) {

            $new_apartment = new Apartment();

            $new_apartment->title = $data['title'];
            $new_apartment->slug = Str::slug($new_apartment->title);
            $new_apartment->city = $data['city'];
            $new_apartment->street_name = $data['street_name'];
            $new_apartment->street_number = $data['street_number'];
            $new_apartment->postal_code = $data['postal_code'];
            $new_apartment->country = $data['country'];
            $new_apartment->country_code = $data['country_code'];
            $new_apartment->latitude = $data['latitude'];
            $new_apartment->longitude = $data['longitude'];
            $new_apartment->visibility = $faker->boolean();
            $new_apartment->user_id = User::all()->random()->id;

            $new_apartment->save();

            $apartment_info = new Apartment_info();
            $apartment_info->apartment_id = $new_apartment->id;
            $apartment_info->mt_square = $faker->numberBetween(20, 1500);
            $apartment_info->num_rooms = round($apartment_info->mt_square / 20, 0, PHP_ROUND_HALF_UP);
            $apartment_info->num_bathrooms = round($apartment_info->mt_square / 70, 0, PHP_ROUND_HALF_UP);
            $apartment_info->num_beds = round($apartment_info->num_rooms * 0.60, 0, PHP_ROUND_HALF_UP);
            $apartment_info->save();
            $services = Service::inRandomOrder()->take(rand(1, count($services)))->pluck('id');
            $new_apartment->services()->attach($services);

        }
    }
}
