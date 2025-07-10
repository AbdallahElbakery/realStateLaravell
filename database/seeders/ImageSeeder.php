<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $now = Carbon::now();

        $images = [
            ['property_id' => 2, 'image' => 'https://images.pexels.com/photos/259588/pexels-photo-259588.jpeg'],
            ['property_id' => 3, 'image' => 'https://images.pexels.com/photos/276724/pexels-photo-276724.jpeg'],
            ['property_id' => 4, 'image' => 'https://images.pexels.com/photos/2102587/pexels-photo-2102587.jpeg'],
            ['property_id' => 5, 'image' => 'https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg'],
            ['property_id' => 6, 'image' => 'https://images.pexels.com/photos/259957/pexels-photo-259957.jpeg'],
            ['property_id' => 7, 'image' => 'https://images.pexels.com/photos/280222/pexels-photo-280222.jpeg'],
            ['property_id' => 8, 'image' => 'https://images.pexels.com/photos/323775/pexels-photo-323775.jpeg'],
            ['property_id' => 9, 'image' => 'https://images.pexels.com/photos/259165/pexels-photo-259165.jpeg'],
            ['property_id' => 10,'image' => 'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg'],
        ];

        foreach ($images as $image) {
            DB::table('images')->insert([
                'property_id' => $image['property_id'],
                'image' => $image['image'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
