<?php

namespace App\Livewire;

use Livewire\Component;
use Str;
use File;

class Signature extends Component
{
    public $signature;

    public function submit()
    {
        // Create signatures directory if it doesn't exist
        $directory = public_path('signatures');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Save the signature
        $imageData = base64_decode(Str::of($this->signature)->after(','));
        File::put(public_path('signatures/signature2.png'), $imageData);
    }


    public function render()
    {
        return view('livewire.signature');
    }
}