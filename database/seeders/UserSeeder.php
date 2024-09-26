<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* This PHP code is a Seeder class in Laravel, specifically for seeding the `users` table in
        the database with some initial data. Here's what each part of the code does: */
        DB::table('users')->delete();

        $user = [
            [
                'id' => '1', 'first_name' => 'Mr','last_name' => 'Admin','email' => 'admin@gmail.com', 'phone' => '01712345678', 'gender' => 1, 'status' => 1, 'is_admin' => 1, 'password' => Hash::make('admin@12345'), 'address' => 'Dhanmondi, Dhaka',
            ],
            [
                'id' => '2', 'first_name' => 'John','last_name' => 'Doe','email' => 'johndoe@gmail.com', 'phone' => '01723456789', 'gender' => 1, 'status' => 1, 'is_admin' => 0, 'password' => Hash::make('johndoe@12345'), 'address' => 'Mirpur, Dhaka',
            ]
        ];

        foreach ($user as $user) {
            User::create($user);
        }
    }
}
