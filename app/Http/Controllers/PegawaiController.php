<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PegawaiExport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    private function authorizeAdmin()
    {
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized');
        }
    }

    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $users = User::query();

        if ($request->filled('role')) {
            $users->where('role', $request->role);
        }

        if ($request->created_sort === 'latest') {
            $users->orderByDesc('created_at');
        } elseif ($request->created_sort === 'oldest') {
            $users->orderBy('created_at');
        }

        if ($request->sort_name === 'asc') {
            $users->orderBy('name');
        } elseif ($request->sort_name === 'desc') {
            $users->orderByDesc('name');
        }

        $userList = $users->get();
        $queryString = $request->query();

        return view('pegawai.index', [
            'title' => 'Pegawai',
            'fullTitle' => 'Manajemen Pegawai',
            'moduleIcon' => 'fas fa-user-tie',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.index')],
                ['label' => 'Pegawai', 'url' => route('pegawai.index')],
            ],
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
            'data' => $userList,
            'users' => $userList,
            'action' => route('pegawai.store'),
            'isDetail' => false,
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:Admin,Petugas,Marketing,Member',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'saldo' => $request->saldo ?? 0,
            'tanggal_daftar' => $request->tanggal_daftar ?? now(),
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();

        $user = User::findOrFail($id);
        $users = User::all();
        $queryString = request()->query();

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
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|confirmed|min:6',
            'role' => 'required|in:Admin,Petugas,Marketing,Member',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->phone_number = $request->phone_number;
        $user->birth_date = $request->birth_date;
        $user->address = $request->address;
        $user->saldo = $request->saldo ?? 0;
        $user->tanggal_daftar = $request->tanggal_daftar ?? $user->tanggal_daftar;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('pegawai.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        User::findOrFail($id)->delete();
        return redirect()->route('pegawai.index')->with('success', 'Data berhasil dihapus.');
    }

    // --- EXPORTS & IMPORTS ---

    public function import(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Import berhasil');
    }

    public function exportPdf()
    {
        $this->authorizeAdmin();

        $users = User::all();
        $pdf = Pdf::loadView('pegawai.exports.pdf', compact('users'))->setPaper('a4', 'landscape');
        return $pdf->stream('data_pegawai.pdf');
    }

    public function exportPrint()
    {
        $this->authorizeAdmin();
        $users = User::all();
        return view('pegawai.exports.print', compact('users'));
    }

    public function exportExcel()
    {
        $this->authorizeAdmin();
        return Excel::download(new PegawaiExport, 'data_pegawai.xlsx');
    }

    public function exportCsv()
    {
        $this->authorizeAdmin();
        return Excel::download(new PegawaiExport, 'data_pegawai.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportJson()
    {
        $this->authorizeAdmin();

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
