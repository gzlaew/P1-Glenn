<?php

namespace App\Http\Controllers;

use App\Models\Penerbit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;

class PenerbitController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->get('sort_name') ? 'nama_penerbit' : 'created_at';
        $sortOrder = $request->get('sort_name') ?? $request->get('sort_date') ?? 'desc';

        $penerbitList = Penerbit::when($request->search, function ($query) use ($request) {
            $query->where('nama_penerbit', 'like', "%{$request->search}%");
        })->orderBy($sortField, $sortOrder)->get();

        return view('penerbit.index', [
            'title' => 'Penerbit',
            'fullTitle' => 'Manajemen Penerbit',
            'moduleIcon' => 'fas fa-building',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.index')],
                ['label' => 'Penerbit', 'url' => route('penerbit.index')],
            ],
            'routeIndex' => route('penerbit.index'),
            'route_create' => route('penerbit.index'),
            'routePdf' => route('penerbit.pdf'),
            'routePrint' => route('penerbit.pdf'),
            'routeExcel' => route('penerbit.excel'),
            'routeCsv' => route('penerbit.csv'),
            'routeJson' => route('penerbit.json'),
            'routeImportExcel' => '#',
            'routeExampleExcel' => '#',
            'canExport' => true,
            'canCreate' => true,
            'canImportExcel' => false,
            'data' => $penerbitList,
            'penerbitList' => $penerbitList,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_penerbit' => 'required|unique:tb_penerbit,nama_penerbit',
        ]);

        Penerbit::create([
            'nama_penerbit' => $request->nama_penerbit,
        ]);

        return redirect()->route('penerbit.index')->with('success', 'Penerbit berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $penerbit = Penerbit::findOrFail($id);
        $penerbitList = Penerbit::all();

        return view('penerbit.index', [
            'penerbit' => $penerbit,
            'penerbitList' => $penerbitList,
            'data' => $penerbitList,
            'title' => 'Penerbit',
            'fullTitle' => 'Edit Penerbit',
            'moduleIcon' => 'fas fa-building',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.index')],
                ['label' => 'Penerbit', 'url' => route('penerbit.index')],
                ['label' => 'Edit', 'url' => '#'],
            ],
            'routeIndex' => route('penerbit.index'),
            'route_create' => route('penerbit.index'),
            'routePdf' => route('penerbit.pdf'),
            'routePrint' => route('penerbit.pdf'),
            'routeExcel' => route('penerbit.excel'),
            'routeCsv' => route('penerbit.csv'),
            'routeJson' => route('penerbit.json'),
            'routeImportExcel' => '#',
            'routeExampleExcel' => '#',
            'canExport' => true,
            'canCreate' => true,
            'canImportExcel' => false,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_penerbit' => 'required|unique:tb_penerbit,nama_penerbit,' . $id . ',id_penerbit',
        ]);

        $penerbit = Penerbit::findOrFail($id);
        $penerbit->update($request->only('nama_penerbit'));

        return redirect()->route('penerbit.index')->with('success', 'Penerbit berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Penerbit::findOrFail($id)->delete();
        return redirect()->route('penerbit.index')->with('success', 'Penerbit berhasil dihapus.');
    }

    public function exportPdf()
    {
        $penerbitList = Penerbit::all();
        $pdf = Pdf::loadView('penerbit.exports.pdf', compact('penerbitList'));
        return $pdf->download('data_penerbit.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new GenericExport('tb_penerbit'), 'data_penerbit.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new GenericExport('tb_penerbit'), 'data_penerbit.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportJson()
    {
        $penerbitList = Penerbit::all();
        return response()->json([
            'success' => true,
            'data' => $penerbitList->map(fn($p) => [
                'id' => $p->id_penerbit,
                'nama_penerbit' => $p->nama_penerbit,
                'created_at' => $p->created_at->format('Y-m-d H:i:s')
            ])
        ]);
    }
}
