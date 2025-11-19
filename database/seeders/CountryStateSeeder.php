<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = database_path('dump/countries.sql');
        $states = database_path('dump/states.sql');

        DB::unprepared(file_get_contents($countries));
        DB::unprepared(file_get_contents($states));
    }
}
