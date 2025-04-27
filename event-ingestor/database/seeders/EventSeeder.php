<?php

namespace Database\Seeders;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $userID = Str::uuid()->toString();
            for ($j = 0; $j < mt_rand(1, 100); $j++) {
                Event::create([
                    "user_id" => $userID,
                    "event_type" => "view_page",
                    "happened_at" => Carbon::now()->subDays(mt_rand(1, 29)),
                    "metadata" => ""
                ]);
            }
        }

        for ($i = 0; $i < 50; $i++) {
            $userID = Str::uuid()->toString();
            for ($j = 0; $j < mt_rand(1, 10); $j++) {
                Event::create([
                    "user_id" => $userID,
                    "event_type" => "purchase",
                    "happened_at" => Carbon::now()->subDays(mt_rand(1, 29)),
                    "metadata" => ""
                ]);
            }
        }

    }
}
