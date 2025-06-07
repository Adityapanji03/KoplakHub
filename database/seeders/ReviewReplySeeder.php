<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('review_replies')->insert([
            [
                'id' => 1,
                'review_id' => 2,
                'admin_id' => 1,
                'reply' => 'ora',
                'created_at' => Carbon::parse('2025-05-20 00:39:59'),
                'updated_at' => Carbon::parse('2025-05-20 00:41:59'),
            ],
            [
                'id' => 2,
                'review_id' => 1,
                'admin_id' => 1,
                'reply' => 'anjay',
                'created_at' => Carbon::parse('2025-05-20 01:02:00'),
                'updated_at' => Carbon::parse('2025-05-20 01:02:00'),
            ],
            [
                'id' => 3,
                'review_id' => 3,
                'admin_id' => 1,
                'reply' => 'oke sip oke',
                'created_at' => Carbon::parse('2025-05-22 10:24:46'),
                'updated_at' => Carbon::parse('2025-05-22 10:24:56'),
            ],
        ]);

    }
}
