<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = ['Egypt', 'USA', 'Canada', 'Germany', 'France'];
        $cities = ['Cairo', 'Alexandria', 'New York', 'Berlin', 'Paris', 'Toronto', 'Luxor'];

        for ($i = 1; $i <= 10; $i++) {
            $country = $countries[array_rand($countries)];
            $city = $cities[array_rand($cities)];
            $street = 'Street ' . rand(1, 100);

            DB::table('addresses')->insert([
                'country' => $country,
                'city' => $city,
                'postal_code' => rand(10000, 99999),
                'street' => $street,
                'full_address' => $street . ', ' . $city . ', ' . $country,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }
}
}
