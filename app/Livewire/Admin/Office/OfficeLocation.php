<?php

namespace App\Livewire\Admin\Office;

use Livewire\Component;
use App\Models\Office;

class OfficeLocation extends Component
{
    public $selectedLocation = null;
    public $latitude = -6.2088;
    public $longitude = 106.8456;
    public $radius = 200;
    public $locations;
    public $search = '';

    public function mount()
    {
        $this->locations = \App\Models\OfficeLocation::all();

        if ($this->locations->isNotEmpty()) {
            $this->selectedLocation = $this->locations->first();
            $this->latitude = $this->selectedLocation->latitude;
            $this->longitude = $this->selectedLocation->longitude;
            $this->radius = $this->selectedLocation->radius;
        }
    }

    public function selectLocation($locationId)
    {
        $this->selectedLocation = \App\Models\OfficeLocation::find($locationId);
        if ($this->selectedLocation) {
            $this->latitude = $this->selectedLocation->latitude;
            $this->longitude = $this->selectedLocation->longitude;
            $this->radius = $this->selectedLocation->radius;

            $this->dispatch('updateMarker', [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'radius' => $this->radius
            ]);
        }
    }

    public function updatedRadius($value)
    {
        if ($this->selectedLocation) {
            $this->selectedLocation->update(['radius' => $value]);
            $this->dispatch('updateMarker', [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'radius' => $value
            ]);
        }
    }


    public function updatedLatitude($value)
    {
        if ($this->selectedLocation) {
            $this->selectedLocation->update([
                'latitude' => $value,
                'longitude' => $this->longitude
            ]);
        }
    }

    public function updatedLongitude($value)
    {
        if ($this->selectedLocation) {
            $this->selectedLocation->update([
                'latitude' => $this->latitude,
                'longitude' => $value
            ]);
        }
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