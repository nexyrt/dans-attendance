<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Holiday;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HolidaySeeder extends Seeder
{
    // Define holidays as a protected property for easy maintenance
    protected $holidays2024 = [
        [
            'title' => 'Tahun Baru Masehi',
            'date' => '2024-01-01',
            'days' => 1,
            'description' => 'Hari libur nasional untuk merayakan tahun baru.'
        ],
        [
            'title' => 'Hari Raya Idul Fitri',
            'date' => '2024-04-10',
            'days' => 2,
            'description' => 'Hari libur nasional untuk merayakan Idul Fitri.'
        ],
        [
            'title' => 'Hari Raya Idul Adha',
            'date' => '2024-06-17',
            'days' => 1,
            'description' => 'Hari libur nasional untuk merayakan Idul Adha.'
        ],
        [
            'title' => 'Hari Kemerdekaan Indonesia',
            'date' => '2024-08-17',
            'days' => 1,
            'description' => 'Hari libur nasional untuk memperingati kemerdekaan Indonesia.'
        ],
        [
            'title' => 'Hari Natal',
            'date' => '2024-12-25',
            'days' => 1,
            'description' => 'Hari libur nasional untuk merayakan Natal.'
        ],
    ];

    public function run()
    {
        foreach ($this->holidays2024 as $holiday) {
            $startDate = Carbon::parse($holiday['date'])->startOfDay();
            $endDate = Carbon::parse($holiday['date'])
                ->addDays($holiday['days'] - 1)
                ->endOfDay();

            Holiday::create([
                'title' => $holiday['title'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'description' => $holiday['description'],
            ]);
        }

        
    }
}
