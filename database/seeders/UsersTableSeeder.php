<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'department_id' => Department::where('name', 'HR')->first()->id,
        ]);

        // Create director
        User::create([
            'name' => 'Director',
            'email' => 'director@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'director',
            'department_id' => Department::inRandomOrder()->first()->id,
        ]);

        // Create manager
        User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'manager',
            'department_id' => Department::inRandomOrder()->first()->id,
        ]);

        // Create additional random users
        User::factory(5)->create(['role' => 'staff']);
        User::factory(2)->create(['role' => 'manager']);
    }
}