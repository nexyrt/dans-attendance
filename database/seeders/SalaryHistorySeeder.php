<?php

namespace Database\Seeders;

use App\Models\SalaryHistory;
use Illuminate\Database\Seeder;

class SalaryHistorySeeder extends Seeder
{
    public function run(): void
    {
        SalaryHistory::factory(30)->create();
    }
}
