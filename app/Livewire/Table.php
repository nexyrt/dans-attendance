<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class Table extends Component
{
    use WithPagination;

    public $searchName = '';
    public $searchPosition = '';
    public $searchDepartment = '';

    protected $updatesQueryString = [
        'searchName' => ['except' => ''],
        'searchPosition' => ['except' => ''],
        'searchDepartment' => ['except' => ''],
    ];

    public function updatingSearchName()
    {
        $this->resetPage();
    }

    public function updatingSearchPosition()
    {
        $this->resetPage();
    }

    public function updatingSearchDepartment()
    {
        $this->resetPage();
    }

    public function setDepartment($department)
    {
        $this->searchDepartment = $department;
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->when($this->searchName, function($query) {
                $query->where('name', 'like', '%'.$this->searchName.'%');
            })
            ->when($this->searchPosition, function($query) {
                $query->where('position', 'like', '%'.$this->searchPosition.'%');
            })
            ->when($this->searchDepartment, function($query) {
                $query->where('department', $this->searchDepartment);
            })
            ->paginate(10);

        return view('livewire.table', [
            'users' => $users
        ]);
    }
}
