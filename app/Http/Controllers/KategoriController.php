<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    private function authorizeAdmin()
    {
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized');
        }
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['Admin', 'Petugas'])) {
            abort(403, 'Unauthorized');
        }

        $kategoriList = Kategori::when($request->search, function ($query) use ($request) {
            $query->where('nama_kategori', 'like', "%{$request->search}%");
        })->get();

        $data = $kategoriList;
        $title = 'Manajemen Kategori';
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard.index')],
            ['label' => 'Kategori', 'url' => route('kategori.index')],
        ];
        $moduleIcon = 'fas fa-tags';
        $route_create = route('kategori.index');
        $routeImportExcel = '#';
        $routeExampleExcel = '';
        $canCreate = $user->role === 'Admin';
        $canExport = $user->role === 'Admin';
        $canImportExcel = false;

        return view('kategori.index', compact(
            'kategoriList',
            'data',
            'title',
            'breadcrumbs',
            'moduleIcon',
            'route_create',
            'routeImportExcel',
            'routeExampleExcel',
            'canCreate',
            'canExport',
            'canImportExcel'
        ));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nama_kategori' => 'required|unique:tb_kategori,nama_kategori',
        ]);

        Kategori::create($request->only('nama_kategori'));
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();

        $kategori = Kategori::findOrFail($id);
        $kategoriList = Kategori::all();

        $data = $kategoriList;
        $title = 'Edit Kategori';
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard.index')],
            ['label' => 'Kategori', 'url' => route('kategori.index')],
            ['label' => 'Edit', 'url' => '#'],
        ];
        $moduleIcon = 'fas fa-tags';
        $route_create = route('kategori.index');
        $routeImportExcel = '#';
        $routeExampleExcel = '';
        $canCreate = true;
        $canExport = true;
        $canImportExcel = false;

        return view('kategori.index', compact(
            'kategori',
            'kategoriList',
            'data',
            'title',
            'breadcrumbs',
            'moduleIcon',
            'route_create',
            'routeImportExcel',
            'routeExampleExcel',
            'canCreate',
            'canExport',
            'canImportExcel'
        ));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nama_kategori' => 'required|unique:tb_kategori,nama_kategori,' . $id . ',id_kategori',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->only('nama_kategori'));
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();
        Kategori::findOrFail($id)->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    public function exportPdf()
    {
        $this->authorizeAdmin();
        $kategoriList = Kategori::all();
        $pdf = Pdf::loadView('kategori.exports.pdf', compact('kategoriList'));
        return $pdf->download('kategori.pdf');
    }

    public function exportExcel()
    {
        $this->authorizeAdmin();
        return Excel::download(new GenericExport('tb_kategori'), 'kategori.xlsx');
    }

    public function exportCsv()
    {
        $this->authorizeAdmin();
        return Excel::download(new GenericExport('tb_kategori'), 'kategori.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportJson()
    {
        $this->authorizeAdmin();
        $kategoriList = Kategori::all();
        return response()->json($kategoriList);
    }
}
