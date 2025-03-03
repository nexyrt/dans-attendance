<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class Signature extends Component
{
    public $signature;

    public function submit()
    {
        $user = Auth::user();
        
        // Create signatures directory if it doesn't exist
        $directory = public_path('signatures');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Generate filename using role, name, and user ID
        $filename = sprintf(
            '%s_%s_%s.png',
            strtolower($user->role),
            Str::slug($user->name),
            $user->id
        );

        // Save the signature
        $imageData = base64_decode(Str::of($this->signature)->after(','));
        File::put(public_path('signatures/' . $filename), $imageData);
    }

    public function render()
    {
        return view('livewire.signature');
    }
}