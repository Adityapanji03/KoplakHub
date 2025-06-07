<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import DB facade
use Carbon\Carbon; // Import Carbon for timestamps

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'id' => 1,
                'akun_id' => 2,
                'produk_id' => 1,
                'transaksi_id' => 13,
                'rating' => 2,
                'review' => 'aa',
                'is_published' => 1,
                'created_at' => Carbon::parse('2025-05-19 23:24:23'), // Use Carbon to parse timestamps
                'updated_at' => Carbon::parse('2025-05-19 23:34:18'),
            ],
            [
                'id' => 2,
                'akun_id' => 2,
                'produk_id' => 1,
                'transaksi_id' => 14,
                'rating' => 5,
                'review' => 'mantap',
                'is_published' => 1,
                'created_at' => Carbon::parse('2025-05-19 23:44:03'),
                'updated_at' => Carbon::parse('2025-05-19 23:44:03'),
            ],
            [
                'id' => 3,
                'akun_id' => 2,
                'produk_id' => 2,
                'transaksi_id' => 16,
                'rating' => 5,
                'review' => 'mantap',
                'is_published' => 1,
                'created_at' => Carbon::parse('2025-05-21 14:38:27'),
                'updated_at' => Carbon::parse('2025-05-21 14:38:27'),
            ],
            [
                'id' => 4,
                'akun_id' => 2,
                'produk_id' => 1,
                'transaksi_id' => 18,
                'rating' => 5,
                'review' => 'mantul jir',
                'is_published' => 1,
                'created_at' => Carbon::create(2025, 5, 22, 19, 31, 34),
                'updated_at' => Carbon::create(2025, 5, 22, 19, 31, 34),
            ],
            [
                'id' => 5,
                'akun_id' => 2,
                'produk_id' => 4,
                'transaksi_id' => 18,
                'rating' => 5,
                'review' => 'hayyukkkkk',
                'is_published' => 1,
                'created_at' => Carbon::create(2025, 5, 22, 19, 31, 45),
                'updated_at' => Carbon::create(2025, 5, 22, 19, 31, 45),
            ],
            [
                'id' => 6,
                'akun_id' => 2,
                'produk_id' => 2,
                'transaksi_id' => 18,
                'rating' => 5,
                'review' => 'ak 2 juta ni bos pal palepale',
                'is_published' => 1,
                'created_at' => Carbon::create(2025, 5, 22, 19, 32, 1),
                'updated_at' => Carbon::create(2025, 5, 22, 19, 32, 1),
            ],
            [
                'id' => 7,
                'akun_id' => 2,
                'produk_id' => 1,
                'transaksi_id' => 21,
                'rating' => 5,
                'review' => 'anjay',
                'is_published' => 1,
                'created_at' => Carbon::create(2025, 5, 22, 19, 51, 41),
                'updated_at' => Carbon::create(2025, 5, 22, 19, 51, 41),
            ],
            [
                'id' => 8,
                'akun_id' => 2,
                'produk_id' => 2,
                'transaksi_id' => 21,
                'rating' => 5,
                'review' => 'palpale pap',
                'is_published' => 1,
                'created_at' => Carbon::create(2025, 5, 22, 19, 51, 50),
                'updated_at' => Carbon::create(2025, 5, 22, 19, 51, 50),
            ],
        ]);
    }
}
