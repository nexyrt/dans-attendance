<?php

namespace App\Livewire\Admin\Office;


use Livewire\Component;

class OfficeLocation extends Component
{
    public $search;
    public $selectedLocation;
    public $name;
    public $address;
    public $latitude;
    public $longitude;
    public $radius;

    protected $listeners = ['updateCoordinates'];

    public function updateCoordinates($data)
    {
        $this->latitude = $data['lat'];
        $this->longitude = $data['lng'];
    }
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

        // Dispatch initial office locations
        $this->dispatchAllOffices();
    }

    public function dispatchAllOffices()
    {
        $locations = \App\Models\OfficeLocation::all();
        $this->dispatch('loadOfficeLocations', $locations);
    }

    public function updateFilter($status)
    {
        $this->filterStatus = $status;
        $this->dispatchAllOffices();
    }

    public function saveLocation()
    {
        $this->validate();

        \App\Models\OfficeLocation::create([
            'name' => $this->name,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'radius' => $this->radius
        ]);

        $this->reset(['name', 'address', 'latitude', 'longitude', 'radius']);
        session()->flash('message', 'Office location saved successfully!');
    }


    public function updatedRadius($value)
    {
        $this->dispatch('radiusUpdated', $value);
    }

    public function selectLocation($id)
    {
        $location = \App\Models\OfficeLocation::find($id);
        $this->selectedLocation = $location;

        // Update form fields
        $this->name = $location->name;
        $this->address = $location->address;
        $this->latitude = $location->latitude;
        $this->longitude = $location->longitude;
        $this->radius = $location->radius;

        // Dispatch event to update map
        $this->dispatch('locationSelected', $location);
    }


    public function render()
    {
        $filteredLocations = \App\Models\OfficeLocation::when($this->search, function ($query) {
            return $query->where('name', 'like', "%{$this->search}%");
        })->get();

        return view('livewire.admin.office.office-location', [
            'filteredLocations' => $filteredLocations
        ]);
    }
}