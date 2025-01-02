<?php

namespace Database\Seeders;

use App\Models\Allowance;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AllowanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        //
        $users = User::whereNotExists(function ($query) {
            $query->select('id')
                  ->from('allowances')
                  ->whereColumn('user_id', 'users.id');
        })->get();

        foreach ($users as $user) {
            // Use factory with role-based states
            $factory = Allowance::factory();
            
            // Create the financial details for the user
            $factory->create([
                'user_id' => $user->id
            ]);
        }
    }
}
