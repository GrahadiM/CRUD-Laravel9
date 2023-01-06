<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleUser = Role::create(['name' => 'user']);
        $roleUser->givePermissionTo([
            // dashboard
            'dashboard-C',
            'dashboard-R',
            'dashboard-U',
            'dashboard-D',
        ]);
        User::create([
            'name' => 'User',
            'email' => 'user@test.com',
            'username' => 'user',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ])->assignRole([$roleUser->id]);
    }
}
