<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class AttendancesExport implements FromQuery, WithHeadings, WithMapping, WithColumnWidths, WithStyles, WithTitle, WithCustomStartCell
{
    use Exportable;

    protected $filters;
    protected $totalRecords;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function title(): string
    {
        return 'Attendance Records';
    }

    public function startCell(): string
    {
        return 'A7';
    }

    /**
     * Convert decimal hours to hours and minutes format
     * Example: 8.5 becomes "8h 30m"
     */
    private function formatDuration(float $hours): string
    {
        if ($hours <= 0)
            return '-';

        $wholeHours = floor($hours);
        $minutes = round(($hours - $wholeHours) * 60);

        // Handle case where minutes round to 60
        if ($minutes == 60) {
            $wholeHours++;
            $minutes = 0;
        }

        if ($minutes == 0) {
            return "{$wholeHours}h";
        }

        return "{$wholeHours}h {$minutes}m";
    }

    /**
     * Calculate overtime hours (any time beyond 8 hours)
     */
    private function calculateOvertime(float $workingHours): string
    {
        if ($workingHours <= 8)
            return '-';

        $overtimeHours = $workingHours - 8;
        return $this->formatDuration($overtimeHours);
    }

    public function styles(Worksheet $sheet)
    {
        $this->totalRecords = $this->query()->count();

        // Set column widths
        foreach ($this->columnWidths() as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        // Top logo section
        $sheet->mergeCells('A1:I2');
        $sheet->setCellValue('A1', 'JKB EMPLOYEE MANAGEMENT');
        $sheet->getStyle('A1:I2')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1A56DB']
            ],
            'font' => [
                'bold' => true,
                'size' => 24,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ]);

        // Report Title Section
        $sheet->mergeCells('A3:I3');
        $sheet->setCellValue('A3', 'Attendance Report');
        $sheet->getStyle('A3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ]
        ]);

        // Period and Records info with side borders
        $startDate = $this->filters['startDate'] ? Carbon::parse($this->filters['startDate'])->format('d M Y') : 'All time';
        $endDate = $this->filters['endDate'] ? Carbon::parse($this->filters['endDate'])->format('d M Y') : 'Present';

        // Period info with left border accent
        $sheet->mergeCells('A4:I4');
        $sheet->setCellValue('A4', "Period: {$startDate} - {$endDate}");
        $sheet->getStyle('A4')->applyFromArray([
            'font' => [
                'size' => 11,
                'color' => ['rgb' => '4B5563']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'left' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '3B82F6']
                ]
            ]
        ]);

        // Total records with right border accent
        $sheet->mergeCells('A5:I5');
        $sheet->setCellValue('A5', "Total Records: {$this->totalRecords}");
        $sheet->getStyle('A5')->applyFromArray([
            'font' => [
                'size' => 11,
                'color' => ['rgb' => '4B5563']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'right' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '3B82F6']
                ]
            ]
        ]);

        // Table Headers
        $headerRange = 'A7:I7';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563EB']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ]
        ]);

        // Data rows styling
        $lastRow = $sheet->getHighestRow();
        $dataRange = 'A8:I' . $lastRow;

        // Center align specific columns
        $sheet->getStyle('A8:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Date
        $sheet->getStyle('D8:H' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Time columns

        $sheet->getStyle($dataRange)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB']
                ]
            ]
        ]);

        // Zebra striping and status colors
        for ($row = 8; $row <= $lastRow; $row++) {
            // Zebra striping
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':I' . $row)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F9FAFB');
            }

            // Status color coding
            $status = $sheet->getCell('G' . $row)->getValue();
            $statusStyle = $sheet->getStyle('G' . $row);

            switch ($status) {
                case 'Present':
                    $color = '059669';
                    $bgColor = 'ECFDF5';
                    break;
                case 'Late':
                    $color = 'DC2626';
                    $bgColor = 'FEF2F2';
                    break;
                case 'Early Leave':
                    $color = 'D97706';
                    $bgColor = 'FFFBEB';
                    break;
                default:
                    $color = '6B7280';
                    $bgColor = 'F3F4F6';
            }

            $statusStyle->applyFromArray([
                'font' => ['color' => ['rgb' => $color]],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $bgColor]
                ]
            ]);

            // Highlight overtime
            $overtimeCell = $sheet->getCell('H' . $row)->getValue();
            if ($overtimeCell && $overtimeCell !== '-') {
                $sheet->getStyle('H' . $row)->applyFromArray([
                    'font' => ['color' => ['rgb' => '7C3AED']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F5F3FF']
                    ]
                ]);
            }
        }

        return $sheet;
    }

    public function query()
    {
        return Attendance::query()
            ->with(['user'])
            ->select([
                'attendances.*',
                'users.name as user_name',
                'users.email as user_email',
            ])
            ->join('users', 'attendances.user_id', '=', 'users.id')
            ->when($this->filters['startDate'] ?? null, fn($q) => $q->where('date', '>=', $this->filters['startDate']))
            ->when($this->filters['endDate'] ?? null, fn($q) => $q->where('date', '<=', $this->filters['endDate']))
            ->when(
                $this->filters['department'] ?? null,
                fn($q) =>
                $q->whereHas('user', function ($query) {
                    $query->whereIn('department_id', $this->filters['department']);
                })
            )
            ->when($this->filters['status'] ?? null, fn($q) => $q->whereIn('status', $this->filters['status']))
            ->when(
                $this->filters['search'] ?? null,
                fn($q) =>
                $q->where(
                    fn($query) =>
                    $query->where('users.name', 'like', '%' . $this->filters['search'] . '%')
                        ->orWhere('users.email', 'like', '%' . $this->filters['search'] . '%')
                )
            )
            ->orderBy('date', 'desc')
            ->orderBy('check_in', 'desc');
    }

    public function map($attendance): array
    {
        $checkIn = $attendance->check_in ? Carbon::parse($attendance->check_in) : null;
        $checkOut = $attendance->check_out ? Carbon::parse($attendance->check_out) : null;

        $workingHours = $attendance->working_hours ?? 0;

        return [
            Carbon::parse($attendance->date)->format('d M Y'),
            $attendance->user_name,
            $attendance->user_email,
            $checkIn ? $checkIn->format('h:i A') : '-',
            $checkOut ? $checkOut->format('h:i A') : '-',
            $this->formatDuration($workingHours),
            ucfirst($attendance->status),
            $this->calculateOvertime($workingHours),
            $attendance->early_leave_reason ?: '-',
        ];
    }

    public function headings(): array
    {
        return [
            'DATE',
            'EMPLOYEE NAME',
            'EMAIL',
            'CHECK IN',
            'CHECK OUT',
            'WORKING HOURS',
            'STATUS',
            'OVERTIME',
            'EARLY LEAVE REASON'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,  // Date
            'B' => 25,  // Employee Name
            'C' => 35,  // Email
            'D' => 15,  // Check In
            'E' => 15,  // Check Out
            'F' => 15,  // Working Hours
            'G' => 15,  // Status
            'H' => 15,  // Overtime
            'I' => 40,  // Early Leave Reason
        ];
    }
}