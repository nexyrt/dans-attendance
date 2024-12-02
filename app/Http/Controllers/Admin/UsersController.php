<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:manajer,admin,staff',
            'department' => 'required|string',
            'position' => 'required|string|in:direktur,manager,staff',
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
            $user->department_id = $request->department;
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
            return redirect()->route('admin.users.index');
        } catch (\Exception $e) {
            notify()->error('Terjadi kesalahan saat menambahkan data.' . $e, 'Error');
            @dd($e->getMessage());
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, $id)  // Changed from User $user to $id
    {
        try {
            // Find the user first
            $user = User::findOrFail($id);

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id, // Changed from $user->id to $id
                'password' => 'nullable|string|min:8',
                'role' => 'required|string',
                'department_id' => 'required|string',
                'position' => 'required|string',
                'phone_number' => 'nullable|string|max:15',
                'birthdate' => 'nullable|date',
                'address' => 'nullable|string',
                'salary' => 'nullable|numeric',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
            ]);



            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('images/users', 'public');
            }

            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user->update($data);
            notify()->success('Data berhasil diubah!', 'Sukses');
            return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            notify()->error('Terjadi kesalahan saat memperbaharui data.' . $e, 'Error');
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        try {
            // Hapus attendance records yang berhubungan
            $user->attendance()->delete();

            if ($user->image) {
                Storage::delete($user->image);
            }

            $user->delete();
            notify()->success('Pengguna berhasil dihapus!', 'Sukses');
            return redirect()->route('admin.users.index')->with('success', 'Karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            notify()->error('Terjadi kesalahan saat memperbaharui data.' . $e, 'Error');
            @dd($e->getMessage());
            return redirect()->back()->withErrors($e->getMessage());
        }

    }
}
