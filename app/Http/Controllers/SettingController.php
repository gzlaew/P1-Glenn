<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $keys = [
            'application_name',
            'company_name',
            'alamat',
            'kontak',
            'biaya_pendaftaran',
            'biaya_peminjaman',
            'biaya_keterlambatan',
            'logo',
        ];

        foreach ($keys as $key) {
            Setting::updateOrInsert(
                ['key' => $key],
                ['value' => $request->$key, 'updated_at' => now()]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
