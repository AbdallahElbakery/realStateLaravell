<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = ['Cairo', 'Alexandria', 'Giza', 'Mansoura', 'Luxor'];
        $payment_methods = ['cash', 'installment'];
        $purposes = ['sold', 'rent'];
        $statuses = ['available', 'sold', 'pending', 'blocked'];
        for ($i = 0; $i <= 10; $i++) {

            DB::table("properties")->insert([
                'name' => 'Property ' . $i,
                'address_id'=>rand(1,10),
                'seller_id' => rand(1, 3),
                'category_id'=>rand(1, 3),
                'description' => STR::random(10),
                'price' => rand(1000, 10000000),
                'city' => array_rand($cities),
                'payment_method' => $payment_methods[array_rand($payment_methods)],
                'purpose' => $purposes[array_rand($purposes)],
                'status' => $statuses[array_rand($statuses)],
                'area' => rand(50, 500),
                'bedrooms' => rand(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
                'wishlist_id'=>1
            ]);

        }
    }
}
