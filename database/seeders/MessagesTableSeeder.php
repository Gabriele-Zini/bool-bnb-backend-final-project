<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for($i = 0; $i < 10; $i++){
            $newMessage = new Message();
            $newMessage->message_content = $faker->paragraph();
            $newMessage->name = $faker->name();
            $newMessage->lastname = $faker->lastName();
            $newMessage->email = $faker->email();
            $newMessage->apartment_id = Apartment::all()->random()->id;
            $newMessage->save();
        }
    }
}
