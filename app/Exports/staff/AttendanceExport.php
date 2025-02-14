<?php

namespace App\Exports\Staff;

use Cake\Chronos\Chronos;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Str;

class AttendanceExport implements
    FromQuery,
    WithMapping,
    WithHeadings,
    ShouldAutoSize,
    WithColumnFormatting,
    WithCustomStartCell,
    WithStyles,
    WithEvents
{
    use Exportable;

    public function __construct(
        protected $startDate,
        protected $endDate,
        protected $status
    ) {
    }

    public function startCell(): string
    {
        return 'A7';
    }

    public function styles(Worksheet $sheet)
    {
        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(15); // Date
        $sheet->getColumnDimension('B')->setWidth(12); // Day
        $sheet->getColumnDimension('C')->setWidth(12); // Check In
        $sheet->getColumnDimension('D')->setWidth(12); // Check Out
        $sheet->getColumnDimension('E')->setWidth(15); // Status
        $sheet->getColumnDimension('F')->setWidth(20); // Check In Location
        $sheet->getColumnDimension('G')->setWidth(20); // Check Out Location
        $sheet->getColumnDimension('H')->setWidth(15); // Working Hours
        $sheet->getColumnDimension('I')->setWidth(30); // Notes

        // Application Header
        $sheet->mergeCells('A1:I2');
        $sheet->setCellValue('A1', 'JKB Attendance');
        $sheet->getStyle('A1:I2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 20],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'] // Indigo color
            ],
            'font' => [
                'color' => ['rgb' => 'FFFFFF']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ]);

        // User Information Section
        $sheet->mergeCells('A4:D4');
        $sheet->setCellValue('A4', 'Employee Information');
        $sheet->getStyle('A4:D4')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E5E7EB']
            ]
        ]);

        $user = Auth::user();
        $sheet->setCellValue('A5', 'Name');
        $sheet->setCellValue('B5', ': ' . $user->name);
        $sheet->setCellValue('A6', 'Department');
        $sheet->setCellValue('B6', ': ' . $user->department->name);

        // Date Range Section
        $sheet->mergeCells('F4:I4');
        $sheet->setCellValue('F4', 'Report Period');
        $sheet->getStyle('F4:I4')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E5E7EB']
            ]
        ]);

        $dateRange = Chronos::parse($this->startDate)->format('d F Y') .
            ' - ' . Chronos::parse($this->endDate)->format('d F Y');
        $sheet->mergeCells('F5:I5');
        $sheet->setCellValue('F5', $dateRange);

        // Table Headers Style
        $tableHeaders = 'A7:I7';
        $sheet->getStyle($tableHeaders)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5']
            ],
            'font' => [
                'color' => ['rgb' => 'FFFFFF']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ]
            ]
        ]);

        return [
            7 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $lastRow = $sheet->getHighestRow();
                $range = 'A7:I' . $lastRow;

                // Zebra striping
                for ($row = 8; $row <= $lastRow; $row++) {
                    if ($row % 2 == 0) {
                        $sheet->getStyle('A' . $row . ':I' . $row)->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'F9FAFB']
                            ]
                        ]);
                    }
                }

                // Add borders to all cells
                $sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'E5E7EB']
                        ]
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER
                    ]
                ]);

                // Color coding for status
                for ($row = 8; $row <= $lastRow; $row++) {
                    $status = $sheet->getCell('E' . $row)->getValue();
                    $color = match (strtolower($status)) {
                        'present' => 'C6F6D5', // Green
                        'late' => 'FEF3C7',    // Yellow
                        'early leave' => 'DBEAFE', // Blue
                        'holiday' => 'E9D5FF',  // Purple
                        default => 'F3F4F6'     // Gray
                    };

                    $sheet->getStyle('E' . $row)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => $color]
                        ]
                    ]);
                }

                // Working hours conditional formatting
                for ($row = 8; $row <= $lastRow; $row++) {
                    $hours = $sheet->getCell('H' . $row)->getValue();
                    $color = match (true) {
                        $hours >= 8 => 'C6F6D5', // Green
                        $hours >= 4 => 'FEF3C7', // Yellow
                        default => 'FEE2E2'      // Red
                    };

                    $sheet->getStyle('H' . $row)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => $color]
                        ]
                    ]);
                }
            }
        ];
    }

    public function query()
    {
        return Auth::user()->attendances()
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->when($this->status !== '', function ($query) {
                $query->where('status', $this->status);
            })
            ->with(['checkInOffice', 'checkOutOffice'])
            ->latest('date');
    }

    public function headings(): array
    {
        return [
            'Date',
            'Day',
            'Check In',
            'Check Out',
            'Status',
            'Check In Location',
            'Check Out Location',
            'Working Hours',
            'Notes'
        ];
    }

    public function map($attendance): array
    {
        return [
            Chronos::parse($attendance->date)->format('d F Y'),
            Chronos::parse($attendance->date)->format('l'),
            $attendance->check_in ? Chronos::parse($attendance->check_in)->format('H:i') : 'Pending',
            $attendance->check_out ? Chronos::parse($attendance->check_out)->format('H:i') : 'Not Yet',
            Str::title(str_replace('_', ' ', $attendance->status)),
            $attendance->checkInOffice?->name ?? 'No Data',
            $attendance->checkOutOffice?->name ?? 'No Data',
            $attendance->working_hours ?? 0,
            $attendance->notes ?? 'No Notes'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'H' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }
}