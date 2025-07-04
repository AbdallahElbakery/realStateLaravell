<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\ComplaintsSeeder;
use Database\Seeders\NotificationsSeeder;
use Database\Seeders\SellerSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\PropertySeeder;
use Database\Seeders\AddressSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(NotificationsSeeder::class);
        // User::factory(10)->create();
        $this->call(ComplaintsSeeder::class);
        $this->call(SellerSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(PropertySeeder::class);
        $this->call(AddressSeeder::class);
        $this->call([ReviewSeeder::class,
    ]);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
