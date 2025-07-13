<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ad;
use Database\Factories\AdFactory;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Ad::factory(50)->create();
        Ad::factory(10)->featured()->create();
        Ad::factory(5)->expired()->create();
    }
}
