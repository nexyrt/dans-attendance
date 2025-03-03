<?php

namespace App\Livewire\Director;

use Livewire\Component;

class Offices extends Component
{
    public $search;
    public $selectedLocation;
    public $name;
    public $address;
    public $latitude;
    public $longitude;
    public $radius;
    public $isEditing = false;

    protected $listeners = ['updateCoordinates'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'address' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'radius' => 'required|numeric|min:10'
    ];

    public function mount()
    {
        $this->latitude = -0.49475;
        $this->longitude = 117.14883;
        $this->radius = 50;
        $this->dispatchAllOffices();
    }

    public function updateCoordinates($data)
    {
        $this->latitude = $data['lat'];
        $this->longitude = $data['lng'];
    }

    public function dispatchAllOffices()
    {
        $locations = \App\Models\OfficeLocation::all();
        $this->dispatch('loadOfficeLocations', $locations);
    }

    public function saveLocation()
    {
        $this->validate();

        if ($this->isEditing && $this->selectedLocation) {
            $this->selectedLocation->update([
                'name' => $this->name,
                'address' => $this->address,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'radius' => $this->radius
            ]);
            
            session()->flash('message', 'Office location updated successfully!');
            $this->isEditing = false;
            $this->dispatch('editModeChanged', false);
        } else {
            \App\Models\OfficeLocation::create([
                'name' => $this->name,
                'address' => $this->address,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'radius' => $this->radius
            ]);
            
            session()->flash('message', 'Office location saved successfully!');
        }

        $this->reset(['name', 'address', 'latitude', 'longitude', 'radius', 'selectedLocation']);
        $this->dispatchAllOffices();
    }

    public function editLocation()
    {
        if ($this->selectedLocation) {
            $this->isEditing = true;
            $this->name = $this->selectedLocation->name;
            $this->address = $this->selectedLocation->address;
            $this->latitude = $this->selectedLocation->latitude;
            $this->longitude = $this->selectedLocation->longitude;
            $this->radius = $this->selectedLocation->radius;
            
            // Dispatch event to enable marker dragging
            $this->dispatch('editModeChanged', true);
        }
    }

    public function deleteLocation()
    {
        if ($this->selectedLocation) {
            $this->selectedLocation->delete();
            session()->flash('message', 'Office location deleted successfully!');
            $this->reset(['name', 'address', 'latitude', 'longitude', 'radius', 'selectedLocation', 'isEditing']);
            $this->dispatch('editModeChanged', false);
            $this->dispatchAllOffices();
        }
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->dispatch('editModeChanged', false);
        $this->reset(['name', 'address', 'latitude', 'longitude', 'radius']);
        if ($this->selectedLocation) {
            $this->selectLocation($this->selectedLocation->id);
        }
    }

    public function selectLocation($id)
    {
        $location = \App\Models\OfficeLocation::find($id);
        $this->selectedLocation = $location;
        // Pass isEditing state to the map
        $this->dispatch('locationSelected', [$location, $this->isEditing]);
    }

    public function render()
    {
        $filteredLocations = \App\Models\OfficeLocation::when($this->search, function ($query) {
            return $query->where('name', 'like', "%{$this->search}%");
        })->get();

        return view('livewire.admin.office.office-location', [
            'filteredLocations' => $filteredLocations
        ])->layout('layouts.director', ['title' => 'Office Locations']);
    }
}
