<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create(['title' => 'Event 1', 'start' => '2024-11-01']);
        Event::create(['title' => 'Event 2', 'start' => '2024-11-05']);
        Event::create(['title' => 'Event 3', 'start' => '2024-11-10']);
    }
}
