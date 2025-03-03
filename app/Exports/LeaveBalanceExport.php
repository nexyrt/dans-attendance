<?php

namespace App\Exports;

use App\Models\LeaveBalance;
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
use PhpOffice\PhpSpreadsheet\Style\Color;
use Carbon\Carbon;

class LeaveBalanceExport implements FromQuery, WithHeadings, WithMapping, WithColumnWidths, WithStyles, WithTitle, WithCustomStartCell
{
    use Exportable;

    protected $filters;
    protected $totalRecords;
    protected $statistics;

    public function __construct(array $filters = [], array $statistics = [])
    {
        $this->filters = $filters;
        $this->statistics = $statistics;
    }

    public function title(): string
    {
        return 'Leave Balance Records';
    }

    public function startCell(): string
    {
        return 'A7';
    }

    public function styles(Worksheet $sheet)
    {
        $this->totalRecords = $this->query()->count();
        
        // Set column widths
        foreach ($this->columnWidths() as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        // Top logo section with colored background
        $sheet->mergeCells('A1:H2');
        $sheet->setCellValue('A1', 'JKB EMPLOYEE MANAGEMENT');
        $sheet->getStyle('A1:H2')->applyFromArray([
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
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '1E429F']
                ]
            ]
        ]);
        $sheet->getRowDimension(1)->setRowHeight(35);
        $sheet->getRowDimension(2)->setRowHeight(0);

        // Report Title Section
        $sheet->mergeCells('A3:H3');
        $sheet->setCellValue('A3', 'Leave Balance Report - ' . ($this->filters['year'] ?? now()->year));
        $sheet->getStyle('A3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['rgb' => '1F2937']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F3F4F6']
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB']
                ]
            ]
        ]);
        $sheet->getRowDimension(3)->setRowHeight(30);

        // Statistics Section with colored accents
        $sheet->mergeCells('A4:H4');
        $sheet->setCellValue('A4', sprintf(
            "Summary - Total Balance: %d | Used Balance: %d | Remaining Balance: %d",
            $this->statistics['total_leave_balance'] ?? 0,
            $this->statistics['total_used_balance'] ?? 0,
            $this->statistics['total_remaining_balance'] ?? 0
        ));
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
        $sheet->mergeCells('A5:H5');
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

        // Spacing before table
        $sheet->getRowDimension(6)->setRowHeight(15);

        // Table Headers
        $headerRange = 'A7:H7';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563EB']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ]);
        $sheet->getRowDimension(7)->setRowHeight(20);

        // Data rows styling
        $lastRow = $sheet->getHighestRow();
        $dataRange = 'A8:H' . $lastRow;
        
        // Basic styling for all data rows
        $sheet->getStyle($dataRange)->applyFromArray([
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

        // Zebra striping and balance coloring
        for ($row = 8; $row <= $lastRow; $row++) {
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':H' . $row)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F9FAFB');
            }
            
            $sheet->getRowDimension($row)->setRowHeight(18);

            // Color coding for remaining balance column
            $remainingBalance = (int)$sheet->getCell('G' . $row)->getValue();
            $usedBalance = (int)$sheet->getCell('F' . $row)->getValue();
            $totalBalance = (int)$sheet->getCell('E' . $row)->getValue();

            $percentageUsed = $totalBalance > 0 ? ($usedBalance / $totalBalance) * 100 : 0;

            if ($percentageUsed >= 80) {
                $color = 'DC2626'; // Red for high usage
                $bgColor = 'FEF2F2';
            } elseif ($percentageUsed >= 50) {
                $color = 'D97706'; // Orange for medium usage
                $bgColor = 'FFFBEB';
            } else {
                $color = '059669'; // Green for low usage
                $bgColor = 'ECFDF5';
            }

            $sheet->getStyle('G' . $row)->applyFromArray([
                'font' => ['color' => ['rgb' => $color]],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $bgColor]
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ]);
        }

        // Center align specific columns
        $sheet->getStyle('A8:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // ID
        $sheet->getStyle('D8:G' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Year and Balances

        // Freeze panes
        $sheet->freezePane('A8');

        return $sheet;
    }

    public function query()
    {
        return LeaveBalance::query()
            ->with('user.department')
            ->when($this->filters['search'] ?? null, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->when($this->filters['year'] ?? null, function ($query, $year) {
                $query->where('year', $year);
            })
            ->when(isset($this->filters['total_balance_min']), function ($query) {
                $query->whereBetween('total_balance', [
                    $this->filters['total_balance_min'],
                    $this->filters['total_balance_max']
                ]);
            })
            ->when(isset($this->filters['used_balance_min']), function ($query) {
                $query->whereBetween('used_balance', [
                    $this->filters['used_balance_min'],
                    $this->filters['used_balance_max']
                ]);
            })
            ->when(isset($this->filters['remaining_balance_min']), function ($query) {
                $query->whereBetween('remaining_balance', [
                    $this->filters['remaining_balance_min'],
                    $this->filters['remaining_balance_max']
                ]);
            })
            ->orderBy('id');
    }

    public function map($balance): array
    {
        return [
            $balance->id,
            $balance->user->name,
            $balance->user->email,
            $balance->user->department->name ?? '-',
            $balance->year,
            $balance->total_balance,
            $balance->used_balance,
            $balance->remaining_balance,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'EMPLOYEE NAME',
            'EMAIL',
            'DEPARTMENT',
            'YEAR',
            'TOTAL BALANCE',
            'USED BALANCE',
            'REMAINING BALANCE',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,     // ID
            'B' => 25,    // Employee Name
            'C' => 35,    // Email
            'D' => 20,    // Department
            'E' => 12,    // Year
            'F' => 15,    // Total Balance
            'G' => 15,    // Used Balance
            'H' => 18,    // Remaining Balance
        ];
    }
}