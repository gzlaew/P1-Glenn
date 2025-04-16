<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PegawaiExport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class PegawaiController extends Controller
{
    public function index()
    {
        $users = User::all();
        $queryString     = request()->query();
        return view('pegawai.index', [
            'title' => 'Pegawai',
            'fullTitle' => 'Manajemen Pegawai',
            'moduleIcon' => 'fas fa-user-tie',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.index')],
                ['label' => 'Pegawai', 'url' => route('pegawai.index')],
            ],
            'routeIndex' => route('pegawai.index'),
            'route_create' => route('pegawai.index'), // tombol tambah gunakan modal
            'routePdf'         => route('pegawai.pdf', $queryString),
            'routePrint'       => route('pegawai.print', $queryString),
            'routeExcel'       => route('pegawai.excel', $queryString),
            'routeCsv'         => route('pegawai.csv', $queryString),
            'routeJson'        => route('pegawai.json', $queryString),
            'routeImportExcel' => route('pegawai.import'),
            'routeExampleExcel' => asset('template_import_pegawai.xlsx'),
            'canExport' => true,
            'canCreate' => true,
            'canImportExcel' => false,
            'data' => $users,
            'users' => $users,
            'action' => route('pegawai.store'),
            'isDetail' => false,
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $users = User::all(); // ini yang akan dikirim ke $data
        $queryString = request()->query(); // kalau belum ada
        return view('pegawai.index', [
            'title' => 'Pegawai',
            'fullTitle' => 'Edit Pegawai',
            'moduleIcon' => 'fas fa-user-tie',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.index')],
                ['label' => 'Pegawai', 'url' => route('pegawai.index')],
                ['label' => 'Edit', 'url' => '#'],
            ],
            'user' => $user,
            'users' => $users,
            'data' => $users,
            'routeIndex' => route('pegawai.index'),
            'route_create' => route('pegawai.index'),
            'routePdf' => route('pegawai.pdf', $queryString),
            'routePrint' => route('pegawai.print', $queryString),
            'routeExcel' => route('pegawai.excel', $queryString),
            'routeCsv' => route('pegawai.csv', $queryString),
            'routeJson' => route('pegawai.json', $queryString),
            'routeImportExcel' => route('pegawai.import'),
            'routeExampleExcel' => asset('template_import_pegawai.xlsx'),
            'canExport' => true,
            'canCreate' => true,
            'canImportExcel' => false,
            'action' => route('pegawai.update', $user->id),
            'isDetail' => false,
            'yajraColumns' => '',
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:Admin,Petugas,Marketing,Member',
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
            'role' => 'required|in:Admin,Petugas,Marketing,Member',
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

    public function import(Request $request)
    {
        // validasi file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        // proses import menggunakan Laravel Excel atau manual
        // Excel::import(new UsersImport, $request->file('file'));

        return redirect()->route('pegawai.index')->with('success', 'Import berhasil');
    }

    public function exportPdf()
    {
        $users = User::all();
        $pdf = Pdf::loadView('pegawai.exports.pdf', compact('users'))->setPaper('a4', 'landscape');
        return $pdf->stream('data_pegawai.pdf');
    }

    public function exportPrint()
    {
        $users = User::all();
        return view('pegawai.exports.print', compact('users'));
    }

    public function exportExcel()
    {
        return Excel::download(new PegawaiExport, 'data_pegawai.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new PegawaiExport, 'data_pegawai.csv', \Maatwebsite\Excel\Excel::CSV);
    }
    public function exportJson()
    {
        $users = User::all();

        return response()->json([
            'success' => true,
            'data' => $users->map(function ($user) {
                return [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                    'role'  => $user->role,
                ];
            }),
        ]);
    }
}
