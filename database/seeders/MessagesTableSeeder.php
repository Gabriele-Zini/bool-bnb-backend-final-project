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
        $messagesData = config('messages');
        foreach($messagesData as $message){
            $newMessage = new Message();
            $newMessage->message_content = $message['message_content'];
            $newMessage->name = $message['name'];
            $newMessage->lastname = $message['lastname'];
            $newMessage->email = $message['email'];
            $newMessage->readed = $message['readed'];
            $newMessage->apartment_id = Apartment::all()->random()->id;
            $newMessage->save();
        }
    }
}
