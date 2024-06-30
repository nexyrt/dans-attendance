<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $model;
    public $columns;
    public $search = '';

    protected $queryString = ['search'];

    public function mount($model, $columns)
    {
        $this->model = $model;
        $this->columns = $columns;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $items = $this->model::where(function($query) {
            foreach ($this->columns as $column) {
                $query->orWhere($column, 'like', '%' . $this->search . '%');
            }
        })->paginate(10);

        return view('livewire.table', [
            'items' => $items,
        ]);
    }
}
