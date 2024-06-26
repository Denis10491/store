<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (env('APP_ENV') === 'dev') {
            $this->call(DevSeeder::class);
        }

        if (env('APP_ENV') === 'prod') {
            $this->call(ProdSeeder::class);
        }
    }
}
