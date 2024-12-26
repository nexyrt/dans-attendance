<?php

namespace Database\Seeders;

use App\Models\EmployeeFinancialDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeFinancialDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Get all users without financial details
        $users = User::whereNotExists(function ($query) {
            $query->select('id')
                  ->from('employee_financial_details')
                  ->whereColumn('user_id', 'users.id');
        })->get();

        foreach ($users as $user) {
            // Use factory with role-based states
            $factory = EmployeeFinancialDetail::factory();
            
            // Apply appropriate state based on user role
            $factory = match ($user->role) {
                'manager' => $factory->manager(),
                'admin' => $factory->manager(), // Admins get manager level
                default => $factory, // Default factory state for staff
            };

            // Create the financial details for the user
            $factory->create([
                'user_id' => $user->id
            ]);
        }
    }
}
