<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, WithHeadings
{
    use Exportable;

    protected $department;
    protected $position;
    protected $name;

    public function __construct($department, $position, $name)
    {
        $this->department = $department;
        $this->position = $position;
        $this->name = $name;
    }

    public function query()
    {
        $query = User::query();

        if ($this->department) {
            $query->where('department', $this->department);
        }

        if ($this->position) {
            $query->where('position', $this->position);
        }

        if ($this->name) {
            $query->where('name', 'like', '%'.$this->name.'%');
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Password',
            'Role',
            'Department',
            'Position',
            'Image',
            'Salary',
            'Address',
            'Phone Number',
            'Birthdate',
        ];
    }
}
