<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $model;
    public $columns;
    public $filters = [];
    public $search = '';
    public $perPage = 10;

    public function mount($model, $columns)
    {
        $this->model = $model;
        $this->columns = $columns;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = $this->model::query();

        foreach ($this->filters as $filter => $value) {
            if ($value) {
                $query->where($filter, 'like', "%$value%");
            }
        }

        if ($this->search) {
            $query->where(function($q) {
                foreach ($this->columns as $column) {
                    $q->orWhere($column, 'like', "%{$this->search}%");
                }
            });
        }

        $data = $query->paginate($this->perPage);

        return view('livewire.table', ['data' => $data]);
    }
}
