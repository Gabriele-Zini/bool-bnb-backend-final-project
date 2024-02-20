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
        $title_array = ['monolocale', 'villetta', 'bilocale', 'trilocale', 'baita', 'casa sull\' albero', 'palafitta', 'villa in montagna', 'villa al mare', 'gulag'];
        $services = Service::all();

        foreach ($title_array as $title) {

            $new_apartment = new Apartment();

            $new_apartment->title = $title;
            $new_apartment->slug = Str::slug($new_apartment->title);
            $new_apartment->city = $faker->city();
            $new_apartment->street_name = $faker->streetName();
            $new_apartment->street_number = $faker->buildingNumber();
            $new_apartment->postal_code = $faker->postcode();
            $new_apartment->country = $faker->country();
            $new_apartment->country_code = $faker->countryISOAlpha3();
            $new_apartment->latitude = $faker->latitude($min = -90, $max = 90);
            $new_apartment->longitude = $faker->longitude($min = -180, $max = 180);
            $new_apartment->visibility = $faker->boolean();
            $new_apartment->user_id = User::all()->first()->id;

            $new_apartment->save();

            $apartment_info = new Apartment_info();
            $apartment_info->apartment_id=$new_apartment->id;
            $apartment_info->mt_square=$faker->numberBetween(30, 300);
            $apartment_info->num_rooms=$faker->numberBetween(2,10);
            $apartment_info->num_bathrooms=$faker->numberBetween(1,5);
            $apartment_info->num_beds=$faker->numberBetween(1, 5);
            $apartment_info->save();
            $services = Service::inRandomOrder()->take(rand(1, count($services)))->pluck('id');
            $new_apartment->services()->attach($services);

        }
    }
}
