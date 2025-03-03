<?php

namespace App\Exports;

use App\Models\LeaveRequest;
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

class LeaveRequestsExport implements FromQuery, WithHeadings, WithMapping, WithColumnWidths, WithStyles, WithTitle, WithCustomStartCell
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
        return 'Leave Requests';
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
        $sheet->setCellValue('A3', 'Leave Requests Report');
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

        // Period and Records info with side borders
        $startDate = $this->filters['startDate'] ? Carbon::parse($this->filters['startDate'])->format('d M Y') : 'All time';
        $endDate = $this->filters['endDate'] ? Carbon::parse($this->filters['endDate'])->format('d M Y') : 'Present';

        // Period info with left border accent
        $sheet->mergeCells('A4:H4');
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

        // Table Headers with gradient-like effect
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

        // Zebra striping and status colors
        for ($row = 8; $row <= $lastRow; $row++) {
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':H' . $row)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F9FAFB');
            }
            
            $sheet->getRowDimension($row)->setRowHeight(18);

            // Status color coding with background
            $status = $sheet->getCell('G' . $row)->getValue();
            $statusStyle = $sheet->getStyle('G' . $row);
            
            switch ($status) {
                case 'Approved':
                    $color = '059669'; // Deep green
                    $bgColor = 'ECFDF5';
                    break;
                case 'Rejected':
                    $color = 'DC2626'; // Deep red
                    $bgColor = 'FEF2F2';
                    break;
                case 'Pending':
                    $color = 'D97706'; // Deep yellow
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
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ]);
        }

        // Center align specific columns
        $sheet->getStyle('A8:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D8:G' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Freeze panes
        $sheet->freezePane('A8');

        return $sheet;
    }

    // Rest of the methods remain the same...
    public function query()
    {
        return LeaveRequest::query()
            ->with(['user', 'approvedBy'])
            ->select([
                'leave_requests.*',
                'users.name as user_name',
                'users.email as user_email',
                'approver.name as approver_name'
            ])
            ->join('users', 'leave_requests.user_id', '=', 'users.id')
            ->leftJoin('users as approver', 'leave_requests.approved_by', '=', 'approver.id')
            ->when($this->filters['startDate'] ?? null, fn($q) => $q->where('start_date', '>=', $this->filters['startDate']))
            ->when($this->filters['endDate'] ?? null, fn($q) => $q->where('end_date', '<=', $this->filters['endDate']))
            ->when($this->filters['leavetype'] ?? null, fn($q) => $q->whereIn('type', $this->filters['leavetype']))
            ->when($this->filters['status'] ?? null, fn($q) => $q->whereIn('status', $this->filters['status']))
            ->when($this->filters['search'] ?? null, fn($q) => 
                $q->where(fn($query) => 
                    $query->where('users.name', 'like', '%' . $this->filters['search'] . '%')
                        ->orWhere('users.email', 'like', '%' . $this->filters['search'] . '%')
                )
            )
            ->orderBy('start_date', 'desc');
    }

    public function map($request): array
    {
        return [
            Carbon::parse($request->start_date)->format('d M Y'),
            $request->user_name,
            $request->user_email,
            ucfirst($request->type),
            Carbon::parse($request->start_date)->format('d M Y') . ' - ' . 
            Carbon::parse($request->end_date)->format('d M Y'),
            $request->approver_name ?: 'Pending',
            ucfirst($request->status),
            $request->reason ?: '-',
        ];
    }

    public function headings(): array
    {
        return [
            'DATE',
            'EMPLOYEE NAME',
            'EMAIL',
            'LEAVE TYPE',
            'PERIOD',
            'APPROVED BY',
            'STATUS',
            'REASON'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,  // Date
            'B' => 25,  // Employee Name
            'C' => 35,  // Email
            'D' => 15,  // Leave Type
            'E' => 25,  // Period
            'F' => 20,  // Approved By
            'G' => 15,  // Status
            'H' => 40,  // Reason
        ];
    }
}