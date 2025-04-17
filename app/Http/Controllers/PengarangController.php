<?php

namespace App\Http\Controllers;

use App\Models\Pengarang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;

class PengarangController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['Admin', 'Petugas'])) {
            abort(403, 'Unauthorized');
        }

        $pengarangQuery = Pengarang::query();

        // Pencarian nama pengarang
        if ($request->filled('search')) {
            $pengarangQuery->where('nama_pengarang', 'like', '%' . $request->search . '%');
        }

        // Urutan berdasarkan nama atau tanggal
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'az':
                    $pengarangQuery->orderBy('nama_pengarang', 'asc');
                    break;
                case 'za':
                    $pengarangQuery->orderBy('nama_pengarang', 'desc');
                    break;
                case 'terbaru':
                    $pengarangQuery->orderBy('created_at', 'desc');
                    break;
                case 'terlama':
                    $pengarangQuery->orderBy('created_at', 'asc');
                    break;
            }
        }

        $pengarangList = $pengarangQuery->get();

        return view('pengarang.index', [
            'pengarangList' => $pengarangList,
            'data' => $pengarangList,
            'title' => 'Pengarang',
            'moduleIcon' => 'fas fa-feather-alt',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.index')],
                ['label' => 'Pengarang', 'url' => route('pengarang.index')],
            ],
            'routeIndex' => route('pengarang.index'),
            'route_create' => route('pengarang.index'),
            'routePdf' => route('pengarang.pdf'),
            'routeExcel' => route('pengarang.excel'),
            'routeCsv' => route('pengarang.csv'),
            'routeJson' => route('pengarang.json'),
            'routeImportExcel' => '#',
            'routeExampleExcel' => '',
            'canExport' => true,
            'canCreate' => true,
            'canImportExcel' => false,
            'isDetail' => false,
            'yajraColumns' => '',
        ]);
    }


    public function store(Request $request)
    {
        $request->validate(['nama_pengarang' => 'required|unique:tb_pengarang']);
        Pengarang::create($request->only('nama_pengarang'));
        return redirect()->route('pengarang.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengarang = Pengarang::findOrFail($id);
        $pengarangList = Pengarang::all();

        return view('pengarang.index', [
            'pengarang' => $pengarang,
            'pengarangList' => $pengarangList,
            'data' => $pengarangList,
            'title' => 'Pengarang',
            'fullTitle' => 'Edit Pengarang',
            'moduleIcon' => 'fas fa-pen-nib',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.index')],
                ['label' => 'Pengarang', 'url' => route('pengarang.index')],
                ['label' => 'Edit', 'url' => '#'],
            ],
            'routeIndex' => route('pengarang.index'),
            'route_create' => route('pengarang.index'),
            'routePdf' => route('pengarang.pdf'),
            'routeExcel' => route('pengarang.excel'),
            'routeCsv' => route('pengarang.csv'),
            'routeJson' => route('pengarang.json'),
            'routeImportExcel' => '#',
            'routeExampleExcel' => '',
            'canExport' => true,
            'canCreate' => true,
            'canImportExcel' => false,
            'isAjax' => false,
            'isYajra' => true,
            'isAjaxYajra' => false
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pengarang' => 'required|unique:tb_pengarang,nama_pengarang,' . $id . ',id_pengarang',
        ]);

        $pengarang = Pengarang::findOrFail($id);
        $pengarang->update($request->only('nama_pengarang'));
        return redirect()->route('pengarang.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Pengarang::findOrFail($id)->delete();
        return redirect()->route('pengarang.index')->with('success', 'Data berhasil dihapus.');
    }

    public function exportPdf()
    {
        $pengarangList = Pengarang::all();
        $pdf = Pdf::loadView('pengarang.exports.pdf', compact('pengarangList'));
        return $pdf->download('pengarang.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new GenericExport('tb_pengarang'), 'pengarang.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new GenericExport('tb_pengarang'), 'pengarang.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportJson()
    {
        $pengarangList = Pengarang::all();
        return response()->json($pengarangList);
    }
}
