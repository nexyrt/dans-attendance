<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserModal extends Component
{
    public $user_id;
    public $name;
    public $email;
    public $password;
    public $role;
    public $department;
    public $position;
    public $phone_number;
    public $birthdate;
    public $address;
    public $salary;
    public $image;
    public $isEdit = false;

    protected $listeners = ['editUser'];

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->department = $user->department;
        $this->position = $user->position;
        $this->phone_number = $user->phone_number;
        $this->birthdate = $user->birthdate;
        $this->address = $user->address;
        $this->salary = $user->salary;
        $this->image = $user->image;
        $this->isEdit = true;

        $this->dispatchBrowserEvent('openModal');
    }

    public function createUser()
    {
        $this->resetFields();
        $this->isEdit = false;
        $this->dispatchBrowserEvent('openModal');
    }

    public function saveUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|in:Admin,Manajer,Staff',
            'department' => 'required|string|in:Jasa & Keuangan,Digital,Marketing',
            'position' => 'required|string|in:Direktur,Manager,Staff,Supervisi',
            'phone_number' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'address' => 'nullable|string',
            'salary' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($this->isEdit) {
            $user = User::find($this->user_id);
        } else {
            $user = new User();
            $user->password = Hash::make($this->password);
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->role = $this->role;
        $user->department = $this->department;
        $user->position = $this->position;
        $user->phone_number = $this->phone_number;
        $user->birthdate = $this->birthdate;
        $user->address = $this->address;

        if ($this->image) {
            $imageName = time() . '.' . $this->image->extension();
            $this->image->storeAs('images/users', $imageName);
            $user->image = 'images/users/' . $imageName;
        }

        $user->salary = $this->salary;
        $user->save();

        $this->dispatchBrowserEvent('closeModal');

        session()->flash('success', 'User successfully saved.');

        $this->emit('userAdded');
    }

    private function resetFields()
    {
        $this->user_id = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->department = '';
        $this->position = '';
        $this->phone_number = '';
        $this->birthdate = '';
        $this->address = '';
        $this->salary = '';
        $this->image = null;
    }

    public function render()
    {
        return view('livewire.admin.user-modal');
    }
}
