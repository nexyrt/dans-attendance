<?php

namespace Database\Seeders;

use App\Models\SalaryDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalaryDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::whereNotExists(function ($query) {
            $query->select('id')
                  ->from('salary_details')
                  ->whereColumn('user_id', 'users.id');
        })->get();

        foreach ($users as $user) {
            $factory = SalaryDetail::factory();

            // Create salary details
            $factory->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
