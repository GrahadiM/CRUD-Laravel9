<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::create(['name' => 'admin']);
        $permissionsAdmin = Permission::pluck('id','id')->all();
        $roleAdmin->syncPermissions($permissionsAdmin);
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@test.com',
            'username' => 'admin',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ])->assignRole([$roleAdmin->id]);
    }
}
