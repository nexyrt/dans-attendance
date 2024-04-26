<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;

class FilteredTableExport implements FromArray
{
    protected $row;

    public function __construct(array $row)
    {
        $this->row = $row;
    }

    public function array(): array
    {
        return $this->row;
    }
}
