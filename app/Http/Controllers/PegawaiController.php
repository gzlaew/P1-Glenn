<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index()
    {
        $users = User::all();
        $title = 'Pegawai';
        $fullTitle = 'Manajemen Pegawai';
        $moduleIcon = 'fas fa-user-tie';
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard.index')],
            ['label' => 'Pegawai', 'url' => route('pegawai.index')],
        ];
        $routeIndex = route('pegawai.index');
        $infoMessage = null;
        $isDetail = false;
        // Untuk mode tambah, action adalah pegawai.store
        $action = route('pegawai.store');

        return view('pegawai.index', compact(
            'users',
            'title',
            'fullTitle',
            'moduleIcon',
            'breadcrumbs',
            'routeIndex',
            'infoMessage',
            'action',
            'isDetail'
        ));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $users = User::all();
        $title = 'Pegawai';
        $fullTitle = 'Edit Pegawai';
        $moduleIcon = 'fas fa-user-tie';
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard.index')],
            ['label' => 'Pegawai', 'url' => route('pegawai.index')],
            ['label' => 'Edit', 'url' => '#'],
        ];
        $routeIndex = route('pegawai.index');
        $infoMessage = null;
        $isDetail = false;
        // Meskipun kita mengirimkan variabel $action, pada view kita akan menggunakan kondisi untuk menentukan action form.
        $action = route('pegawai.update', $user->id);

        return view('pegawai.index', compact(
            'user',
            'users',
            'title',
            'fullTitle',
            'moduleIcon',
            'breadcrumbs',
            'routeIndex',
            'infoMessage',
            'action',
            'isDetail'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:Admin,Petugas,Marketing',
        ]);
        // Tambah data
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Data berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:Admin,Petugas,Marketing',
        ]);
        // Edit data
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->phone_number = $request->phone_number;
        $user->birth_date = $request->birth_date;
        $user->address = $request->address;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('pegawai.index')->with('success', 'Data berhasil diperbarui.');
    }


    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('pegawai.index')->with('success', 'Data berhasil dihapus.');
    }
}
