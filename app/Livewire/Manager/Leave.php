<?php

namespace App\Livewire\Manager;

use Livewire\Component;
use Str;

class Leave extends Component
{
    public $signature;

    public function submit()
    {
        // Check signature exists
        if (!$this->signature) {
            session()->flash('error', 'No signature provided');
            return;
        }

        // Get user info
        $user = auth()->user();

        // Create directory if needed
        $directory = public_path('signatures');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Create filename and save
        $filename = Str::slug("{$user->role}, {$user->name}, {$user->id}") . '.png';
        $image_data = base64_decode(Str::of($this->signature)->after(','));
        file_put_contents("{$directory}/{$filename}", $image_data);

        // Do something with the path if needed
        $relative_path = 'signatures/' . $filename;

        session()->flash('success', 'Signature saved successfully');
    }

    public function render()
    {
        return view('livewire.manager.leave')->layout('layouts.manager', ['title' => 'Leave Management']);
    }
}