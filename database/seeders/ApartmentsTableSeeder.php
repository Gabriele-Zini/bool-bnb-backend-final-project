<?php

namespace Database\Seeders;

use App\Models\Apartment;
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

        $new_apartment = new Apartment();

        foreach ($title_array as $title) {
            $new_apartment->title = $title;
            $new_apartment->slug = Str::slug($new_apartment->title);
            $new_apartment->city = $faker->city();
            $new_apartment->street_name = $faker->streetName();
            $new_apartment->street_number = $faker->buildingNumber();
            $new_apartment->postal_code = $faker->postcode();
            $new_apartment->country = $faker->stateAbbr();
            $new_apartment->latitude = $faker->latitude($min = -90, $max = 90);
            $new_apartment->longitude = $faker->longitude($min = -180, $max = 180);
            $new_apartment->visibility = $faker->boolean();
            $new_apartment->user_id = User::all()->first()->id;
            
            $new_apartment->save();
        }

    }
}
