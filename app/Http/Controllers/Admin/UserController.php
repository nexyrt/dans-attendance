<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:Admin,Manajer,Staff',
            'department' => 'required|string|in:Jasa & Keuangan,Digital,Marketing',
            'position' => 'required|string|in:Direktur,Manager,Staff,Supervisi',
            'phone_number' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'address' => 'nullable|string',
            'salary' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                notify()->error($error, 'Error');
            }
            return redirect()->back()->withInput();
        }

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->department = $request->department;
            $user->position = $request->position;
            $user->phone_number = $request->phone_number;
            $user->birthdate = $request->birthdate;
            $user->address = $request->address;

            if ($request->hasFile('image')) {
                $imageName = str_replace(' ', '_', $request->name) . '_' . time() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('images/users'), $imageName);
                $user->image = 'images/users/' . $imageName;
            }

            $user->salary = str_replace(',', '', $request->salary);
            $user->save();

            notify()->success('Data berhasil ditambahkan!', 'Sukses');
            return redirect()->route('admin.users');
        } catch (\Exception $e) {
            notify()->error('Terjadi kesalahan saat menambahkan data.'.$e, 'Error');
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string',
            'department' => 'required|string',
            'position' => 'required|string',
            'phone_number' => 'nullable|string|max:15',
            'birthdate' => 'nullable|date',
            'address' => 'nullable|string',
            'salary' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Hapus attendance records yang berhubungan
        $user->attendance()->delete();

        if ($user->image) {
            Storage::delete($user->image);
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Karyawan berhasil dihapus.');
    }
}
