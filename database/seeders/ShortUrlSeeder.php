<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShortUrlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sampleUrls = [
            [
                'original_url' => 'https://www.example.com',
                'short_url' => 'short.ly/abcde',
                'click_count' => 10,
                'created_by' => 1, // Example student ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'original_url' => 'https://www.sample.com',
                'short_url' => 'short.ly/fghij',
                'click_count' => 5,
                'created_by' => 2, // Example student ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'original_url' => 'https://www.test.com',
                'short_url' => 'short.ly/klmno',
                'click_count' => 20,
                'created_by' => 1, // Example student ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];


        // Insert sample data into the short_urls table
        DB::table('short_urls')->insert($sampleUrls);
    }
}
