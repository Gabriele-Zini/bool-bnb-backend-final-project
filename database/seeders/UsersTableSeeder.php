<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usersData = config('users');

        foreach ($usersData as $data) {

            $new_user = new User();

            $new_user->name = $data['name'];
            $new_user->lastname = $data['lastname'];
            $new_user->email = $data['email'];
            $new_user->password = Hash::make($data['password']);
            
            $new_user->save();
        }
    }
}
