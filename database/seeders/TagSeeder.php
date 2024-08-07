<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('tags')->delete();

        $tags = [
            [
                'id' => '1',
                'name' => 'Important',
                'status' => true,
            ],
            [
                'id' => '2',
                'name' => 'EEE-0101',
                'status' => true,
            ],
            [
                'id' => '3',
                'name' => 'CSE-0101',
                'status' => true,
            ],
            [
                'id' => '4',
                'name' => 'CSE-0102',
                'status' => true,
            ],
            [
                'id' => '5',
                'name' => 'PHY-0101',
                'status' => true,
            ],
            [
                'id' => '6',
                'name' => 'PHY-0102',
                'status' => true,
            ],
            [
                'id' => '7',
                'name' => 'STA-0101',
                'status' => true,
            ],
            [
                'id' => '8',
                'name' => 'SUB-599',
                'status' => true,
            ],
            [
                'id' => '9',
                'name' => 'ACT-0101',
                'status' => true,
            ],
            [
                'id' => '10',
                'name' => 'CSE-0105',
                'status' => true,
            ],
            [
                'id' => '11',
                'name' => 'EEE-0103',
                'status' => true,
            ],
            [
                'id' => '12',
                'name' => 'MAT-0099',
                'status' => true,
            ],
            [
                'id' => '13',
                'name' => 'CSE-0103',
                'status' => true,
            ],
        ];
        

        foreach ($tags as $tag) {
            Tag::create($tag);
        }

        // Tag::factory()->count(50)->create();
    }
}
