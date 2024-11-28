<?php

namespace Database\Seeders;

use App\Models\Configurations;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Configurations::create(['token' => 'dsgdschihu654776rufjvjh##']);
    }
}
