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
                'id' => '1', 'name' => 'Important', 'status' => true,
            ]
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }

        Tag::factory()->count(50)->create();
    }
}
