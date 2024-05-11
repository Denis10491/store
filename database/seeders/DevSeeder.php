<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DevSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);

        User::factory()->create([
            'email' => env('ADMIN_LOGIN'),
            'password' => env('ADMIN_PASSWORD'),
            'role_id' => 1 // Administrator
        ]);

        $this->call(UserSeeder::class);
        $this->call(OrderSeeder::class);
    }
}
