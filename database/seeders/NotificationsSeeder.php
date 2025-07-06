<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class NotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('notifications')->insert([
            [
                'id' => 2,
                'user_id' => 2,
                'message' => 'first notification',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'user_id' => 2,
                'message' => 'second notification',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'user_id' => 3,
                'message' => 'third notification',
                'is_read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'user_id' => 1,
                'message' => 'fourth notification',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'user_id' => 2,
                'message' => 'fifth notification',
                'is_read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
