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
    public $department = '';
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
        'department' => 'required',
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
            'department',
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
        $this->department = $data['department'];

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

        $department = Department::where('name', $this->department)->first();
        if ($department) {
            $departmentId = $department->id;
        } else {
            $departmentId = null; // Handle the case when the department is not found
        }

        if ($this->isEditing) {
            try {
                $schedule = ScheduleException::find($this->eventId);

                $schedule->update([
                    'title' => $this->title,
                    'start_time' => $this->start_time,
                    'end_time' => $this->end_time,
                    'date' => $this->selectedDate,
                    'department_id' => $departmentId,
                    'status' => $this->status,
                    'note' => $this->description,
                ]);
                notify()->success('Data berhasil diubah!', 'Sukses');
                return redirect()->route('admin.schedules.dashboard');
            } catch (\Exception $e) {
                notify()->error('Terjadi kesalahan saat menambahkan data.' . $e, 'Error');
                return redirect()->back()->withErrors($e->getMessage());
            }
        } else {
            try{
                $schedule = ScheduleException::create([
                    'title' => $this->title,
                    'start_time' => $this->start_time,
                    'end_time' => $this->end_time,
                    'date' => $this->selectedDate,
                    'department_id' => $departmentId,
                    'status' => $this->status,
                    'note' => $this->description,
                ]);
                $this->dispatch('eventCreated', $schedule->id);
                notify()->success('Data berhasil ditambahkan!', 'Sukses');
                return redirect()->route('admin.schedules.dashboard');
            }catch (\Exception $e) {
                notify()->error('Terjadi kesalahan saat menambahkan data.' . $e, 'Error');
                return redirect()->back()->withErrors($e->getMessage());
            }
            
        }

    }
}
