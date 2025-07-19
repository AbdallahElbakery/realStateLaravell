<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'seller', 'user'];
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => '' . $i,
                'email'=> ''.$i,
                "role"=> $roles[array_rand($roles)],
                "phone"=>rand(0,10),
                ""
            ]);
        }
        //
    }
}
