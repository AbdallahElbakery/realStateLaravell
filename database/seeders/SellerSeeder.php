<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sellers')->insert(
            [
                "user_id" =>4 ,
                "company_name" => "Google",
                "logo" => "image.png",
                "personal_id_image" => "image.png",
                "status" => "active",
                "created_at" => now(),
                "updated_at" => now(),
            ]
    );
    }
}
