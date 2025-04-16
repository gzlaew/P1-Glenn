<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;

class MemberAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.member-register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:members,email',
            'phone_number'          => 'required|string|max:20',
            'birth_date'            => 'nullable|date',
            'address'               => 'required|string',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        Member::create([
            'nama'           => $request->name,
            'email'          => $request->email,
            'no_hp'          => $request->phone_number,
            'tanggal_daftar' => now(),
            'alamat'         => $request->address,
            'password'       => Hash::make($request->password),
            'status'         => 'aktif',
            'saldo'          => 0,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
