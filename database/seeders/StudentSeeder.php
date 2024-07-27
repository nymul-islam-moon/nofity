<?php

namespace Database\Seeders;

use App\Models\Student;
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
                'id' => '1', 'first_name' => 'Nymul Islam','last_name' => 'Moon','email' => 'towkir1997islam@gmail.com', 'phone' => '01786287789', 'status' => 1, 'student_id' => "UG02-47-18-017", 'password' => Hash::make('admin@123'), 'address' => 'Dhaka',
            ]
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
