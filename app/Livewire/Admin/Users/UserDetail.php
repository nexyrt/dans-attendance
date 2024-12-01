<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;

class UserDetail extends Component
{
    public User $user;
    public $attendancePeriod = '30';

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.admin.users.user-detail');
    }
}
