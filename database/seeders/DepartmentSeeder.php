<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $departments = [
            ['name' => 'Legal', 'code' => 'LG'],
            ['name' => 'IT', 'code' => 'IT'],
            ['name' => 'Digital Marketing', 'code' => 'DM'],
            ['name' => 'Finance', 'code' => 'FIN'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
