<?php

namespace Database\Seeders;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->delete();

        $students = [
            [
                'id' => 1,
                'first_name' => 'Nymul Islam',
                'last_name' => 'Moon',
                'email' => 'nymulislamlee@gmail.com',
                'phone' => '01786287789',
                'student_id' => 'UG02-47-18-017',
                'status' => 1,
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Moon@12345'),
                'address' => 'Mohammadpur, Dhaka',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
