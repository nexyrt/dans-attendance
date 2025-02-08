<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = ['Digital Marketing', 'Sydital', 'Detax', 'HR'];
        $codes = ['DM', 'SYD', 'DTX', 'HR'];

        foreach ($departments as $index => $department) {
            Department::create([
                'name' => $department,
                'code' => $codes[$index]
            ]);
        }
    }
}
