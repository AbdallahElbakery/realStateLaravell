<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComplaintsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("complaints")->insert([
    [
        "user_id" => 2,
        "subject" => "Login issue",
        "message" => "I can't log in with my email.",
        "created_at" => now(),
        "updated_at" => now(),
    ],
    [
        "user_id" => 3,
        "subject" => "Product not found",
        "message" => "I can't find the product I searched for.",
        "created_at" => now(),
        "updated_at" => now(),
    ],
    [
        "user_id" => 1,
        "subject" => "Order delay",
        "message" => "My order hasn't arrived yet.",
        "created_at" => now(),
        "updated_at" => now(),
    ],
    [
        "user_id" => 3,
        "subject" => "Wrong total amount",
        "message" => "Total price in the cart is not correct.",
        "created_at" => now(),
        "updated_at" => now(),
    ],
    [
        "user_id" => 2,
        "subject" => "UI bug on checkout page",
        "message" => "The confirm button is not working properly.",
        "created_at" => now(),
        "updated_at" => now(),
    ],
]);
    }
}
