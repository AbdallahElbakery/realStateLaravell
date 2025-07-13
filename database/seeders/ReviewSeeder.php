<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // التأكد من وجود مستخدمين وبائعين
        $users = User::where('role', 'user')->take(5)->get();
        $sellers = User::where('role', 'seller')->take(3)->get();

        if ($users->isEmpty() || $sellers->isEmpty()) {
            // إنشاء مستخدمين تجريبيين إذا لم يكونوا موجودين
            $users = User::factory(5)->create(['role' => 'user']);
            $sellers = User::factory(3)->create(['role' => 'seller']);
        }

        $reviews = [
            [
                'user_id' => $users->first()->id,
                'seller_id' => $sellers->first()->id,
                'rating' => 5,
                'comment' => 'Excellent service and the property description was accurate. The seller was very professional and helpful throughout the entire process.',
            ],
            [
                'user_id' => $users->skip(1)->first()->id,
                'seller_id' => $sellers->first()->id,
                'rating' => 4,
                'comment' => 'Great experience working with this seller. They were responsive and helped me find exactly what I was looking for.',
            ],
            [
                'user_id' => $users->skip(2)->first()->id,
                'seller_id' => $sellers->first()->id,
                'rating' => 5,
                'comment' => 'The best real estate broker I have ever dealt with. Highly recommended!',
            ],
            [
                'user_id' => $users->first()->id,
                'seller_id' => $sellers->skip(1)->first()->id,
                'rating' => 4,
                'comment' => 'Good experience but there was some delay in the paperwork. Overall satisfied with the service.',
            ],
            [
                'user_id' => $users->skip(1)->first()->id,
                'seller_id' => $sellers->skip(1)->first()->id,
                'rating' => 5,
                'comment' => 'Amazing service! The seller went above and beyond to help me find my dream home.',
            ],
            [
                'user_id' => $users->skip(2)->first()->id,
                'seller_id' => $sellers->skip(2)->first()->id,
                'rating' => 3,
                'comment' => 'Decent service, but could be more responsive to inquiries.',
            ],
            [
                'user_id' => $users->first()->id,
                'seller_id' => $sellers->skip(2)->first()->id,
                'rating' => 4,
                'comment' => 'Professional and knowledgeable about the local market. Good experience overall.',
            ],
        ];

        foreach ($reviews as $reviewData) {
            Review::create($reviewData);
        }
    }
} 