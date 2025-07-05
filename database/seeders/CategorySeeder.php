<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'id' => 1,
                'category_name' => "Villa",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'category_name' => "Villa",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>3,
                'category_name' => "Villa",
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
