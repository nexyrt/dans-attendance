<?php

namespace App\Livewire\Admin\Schedules;

use Livewire\Component;
use App\Models\Department;
use App\Models\ScheduleException;

class SchedulesExceptionModal extends Component
{
    public $showModal = false;
    public $isEditing = false;
    public $schedule;

    // Form fields
    public $eventId;
    public $title;
    public $start_time = '09:00';
    public $end_time = '10:00';
    public $selectedDate;
    public $selectedDepartments = []; // Changed from department to selectedDepartments
    public $selectedDepartmentNames = []; // For displaying selected departments
    public $status = 'regular';
    public $description;

    protected $listeners = [
        'open-create-modal' => 'openCreateModal',
        'schedule-selected' => 'loadSchedule'
    ];

    protected $rules = [
        'title' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
        'selectedDate' => 'required|date',
        'selectedDepartments' => 'required|array|min:1', // Updated validation rule
        'status' => 'required',
        'description' => 'nullable'
    ];

    public function resetFields()
    {
        $this->reset([
            'eventId',
            'title',
            'start_time',
            'end_time',
            'selectedDate',
            'selectedDepartments',
            'status',
            'description'
        ]);
        $this->start_time = '09:00';
        $this->end_time = '10:00';
        $this->status = 'regular';
    }

    public function openCreateModal()
    {
        $this->resetFields();
        $this->isEditing = false;
        $this->selectedDate = now()->format('Y-m-d');
        $this->showModal = true;
    }

    public function updatedSelectedDepartments($value)
    {
        $this->selectedDepartmentNames = Department::whereIn('id', $this->selectedDepartments)
            ->pluck('name')
            ->toArray();
    }

    public function removeDepartment($departmentName)
    {
        $department = Department::where('name', $departmentName)->first();
        if ($department) {
            $this->selectedDepartments = array_values(array_diff($this->selectedDepartments, [$department->id]));
            $this->selectedDepartmentNames = array_values(array_diff($this->selectedDepartmentNames, [$departmentName]));
        }
    }

    public function render()
    {
        return view('livewire.admin.schedules.schedules-exception-modal', ['departments' => Department::all()]);
    }

    public function openModal()
    {
        $this->resetFields();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function loadSchedule($data)
    {
        $this->isEditing = true;
        $this->eventId = $data['id'];
        $this->title = $data['title'];
        $this->start_time = $data['start_time'];
        $this->end_time = $data['end_time'];
        $this->status = $data['status'];
        $this->selectedDate = $data['date'];
        $this->description = $data['description'];

        // Load existing departments
        $schedule = ScheduleException::with('departments')->find($data['id']);
        $this->selectedDepartments = $schedule->departments->pluck('id')->toArray();
        $this->selectedDepartmentNames = $schedule->departments->pluck('name')->toArray();

        $this->showModal = true;
    }



    public function closeModal()
    {
        $this->showModal = false;
        $this->isEditing = false;

        $this->resetFields();
    }

    public function save()
    {
        $this->validate();
        try {
            if ($this->isEditing) {
                $schedule = ScheduleException::find($this->eventId);
                $schedule->update([
                    'title' => $this->title,
                    'start_time' => $this->start_time,
                    'end_time' => $this->end_time,
                    'date' => $this->selectedDate,
                    'status' => $this->status,
                    'note' => $this->description,
                ]);
            } else {
                $schedule = ScheduleException::create([
                    'title' => $this->title,
                    'start_time' => $this->start_time,
                    'end_time' => $this->end_time,
                    'date' => $this->selectedDate,
                    'status' => $this->status,
                    'note' => $this->description,
                ]);
            }

            // Sync departments
            $schedule->departments()->sync($this->selectedDepartments);

            $this->dispatch('eventCreated', $schedule->id);
            notify()->success($this->isEditing ? 'Data berhasil diubah!' : 'Data berhasil ditambahkan!', 'Sukses');
            return redirect()->route('admin.schedules.dashboard');

        } catch (\Exception $e) {
            notify()->error('Terjadi kesalahan saat ' . ($this->isEditing ? 'mengubah' : 'menambahkan') . ' data.' . $e, 'Error');
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
