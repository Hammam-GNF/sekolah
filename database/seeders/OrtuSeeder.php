<?php

namespace Database\Seeders;

use App\Models\orangTua;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrtuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        orangTua::factory(50)->create();
    }
}
