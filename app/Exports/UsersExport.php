<?php

namespace App\Exports;

use App\Models\User;
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

class UsersExport implements FromQuery, WithHeadings, WithMapping, WithColumnWidths, WithStyles, WithTitle, WithCustomStartCell
{
    use Exportable;

    protected $search;
    protected $selectedDepartments;
    protected $selectedRoles;
    protected $totalRecords;

    public function __construct($search = null, $selectedDepartments = [], $selectedRoles = [])
    {
        $this->search = $search;
        $this->selectedDepartments = $selectedDepartments;
        $this->selectedRoles = $selectedRoles;
    }

    public function title(): string
    {
        return 'Employee Records';
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
        $sheet->mergeCells('A1:J2');
        $sheet->setCellValue('A1', 'JKB EMPLOYEE MANAGEMENT');
        $sheet->getStyle('A1:J2')->applyFromArray([
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
        $sheet->mergeCells('A3:J3');
        $sheet->setCellValue('A3', 'Employee Records');
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

        // Filter info with left border accent
        $filterInfo = [];
        if (!empty($this->selectedDepartments)) {
            $filterInfo[] = "Departments: " . count($this->selectedDepartments);
        }
        if (!empty($this->selectedRoles)) {
            $filterInfo[] = "Roles: " . count($this->selectedRoles);
        }
        if (!empty($this->search)) {
            $filterInfo[] = "Search: " . $this->search;
        }

        $sheet->mergeCells('A4:J4');
        $sheet->setCellValue('A4', !empty($filterInfo) ? "Filters: " . implode(', ', $filterInfo) : "No filters applied");
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
        $sheet->mergeCells('A5:J5');
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
        $headerRange = 'A7:J7';
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
        $dataRange = 'A8:J' . $lastRow;

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

        // Zebra striping and role colors
        for ($row = 8; $row <= $lastRow; $row++) {
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':J' . $row)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F9FAFB');
            }

            $sheet->getRowDimension($row)->setRowHeight(18);

            // Role color coding
            $role = $sheet->getCell('D' . $row)->getValue();
            $roleStyle = $sheet->getStyle('D' . $row);

            switch (strtolower($role)) {
                case 'admin':
                    $color = '059669'; // Green
                    $bgColor = 'ECFDF5';
                    break;
                case 'manager':
                    $color = '1D4ED8'; // Blue
                    $bgColor = 'EFF6FF';
                    break;
                case 'staff':
                    $color = '6B7280'; // Gray
                    $bgColor = 'F3F4F6';
                    break;
                default:
                    $color = '6B7280';
                    $bgColor = 'F3F4F6';
            }

            $roleStyle->applyFromArray([
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
        $sheet->getStyle('D8:E' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Role, Department
        $sheet->getStyle('G8:G' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT); // Salary
        $sheet->getStyle('I8:J' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Phone, Date

        // Freeze panes
        $sheet->freezePane('A8');

        return $sheet;
    }

    public function query()
    {
        $query = User::query()
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'users.role',
                'users.position',
                'users.salary',
                'users.address',
                'users.phone_number',
                'users.created_at',
                'departments.name as department_name'
            ])
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('users.name', 'like', '%' . $this->search . '%')
                        ->orWhere('users.email', 'like', '%' . $this->search . '%')
                        ->orWhere('users.id', 'like', '%' . $this->search . '%');
                });
            })
            ->when(!empty($this->selectedDepartments), function ($q) {
                $q->whereIn('users.department_id', $this->selectedDepartments);
            })
            ->when(!empty($this->selectedRoles), function ($q) {
                $q->whereIn('users.role', $this->selectedRoles);
            });

        return $query;
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            ucfirst($user->role),
            $user->department_name,
            $user->position,
            'Rp ' . number_format($user->salary, 0, ',', '.'),
            $user->address,
            $user->phone_number,
            $user->created_at ? Carbon::parse($user->created_at)->format('d M Y') : '-',
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'NAME',
            'EMAIL',
            'ROLE',
            'DEPARTMENT',
            'POSITION',
            'SALARY',
            'ADDRESS',
            'PHONE NUMBER',
            'JOINED DATE'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,     // ID
            'B' => 25,    // Name
            'C' => 35,    // Email
            'D' => 15,    // Role
            'E' => 20,    // Department
            'F' => 20,    // Position
            'G' => 20,    // Salary
            'H' => 35,    // Address
            'I' => 20,    // Phone Number
            'J' => 15,    // Joined Date
        ];
    }
}