<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Carbon;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;



class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        $queryString = request()->query();

        return view('member.index', [
            'title' => 'Member',
            'fullTitle' => 'Manajemen Member',
            'moduleIcon' => 'fas fa-users',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.index')],
                ['label' => 'Member', 'url' => route('member.index')],
            ],
            'routeIndex' => route('member.index'),
            'route_create' => route('member.index'),
            'routePdf' => route('member.pdf', $queryString),
            'routePrint' => route('member.pdf', $queryString),
            'routeExcel' => route('member.excel', $queryString),
            'routeCsv' => route('member.csv', $queryString),
            'routeJson' => route('member.json', $queryString),
            'routeImportExcel' => route('member.import'),
            'routeExampleExcel' => asset('template_import_member.xlsx'),
            'canExport' => true,
            'canCreate' => true,
            'canImportExcel' => false,
            'data' => $members,
            'members' => $members,
            'action' => route('member.store'),
            'isDetail' => false,
            'yajraColumns' => '',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:members,email',
            'no_hp' => 'required',
            'saldo' => 'required|integer',
            'status' => 'required',
        ]);

        Member::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'saldo' => $request->saldo,
            'status' => $request->status,
            'tanggal_daftar' => now(),
        ]);

        return redirect()->route('member.index')->with('success', 'Member berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        $members = Member::all();
        $queryString = request()->query();

        return view('member.index', [
            'member' => $member,
            'members' => $members,
            'data' => $members, // <- diperlukan untuk datatable layout
            'title' => 'Member',
            'fullTitle' => 'Edit Member',
            'moduleIcon' => 'fas fa-users',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.index')],
                ['label' => 'Member', 'url' => route('member.index')],
                ['label' => 'Edit', 'url' => '#'],
            ],
            'routeIndex' => route('member.index'),
            'route_create' => route('member.index'),
            'routePdf' => route('member.pdf', $queryString),
            'routePrint' => route('member.pdf', $queryString),
            'routeExcel' => route('member.excel', $queryString),
            'routeCsv' => route('member.csv', $queryString),
            'routeJson' => route('member.json', $queryString),
            'routeImportExcel' => route('member.import'),
            'routeExampleExcel' => asset('template_import_member.xlsx'),

            // ✅ tambahkan ini:
            'canExport' => true,
            'canCreate' => true,
            'canImportExcel' => false,

            'action' => route('member.update', $member->id_member),
            'isDetail' => false,
            'yajraColumns' => '',
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:members,email,' . $id . ',id_member',
            'no_hp' => 'required',
            'saldo' => 'required|integer',
            'status' => 'required',
        ]);

        $member = Member::findOrFail($id);
        $member->update($request->only(['nama', 'email', 'no_hp', 'saldo', 'status']));

        return redirect()->route('member.index')->with('success', 'Member berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Member::findOrFail($id)->delete();
        return redirect()->route('member.index')->with('success', 'Member berhasil dihapus.');
    }

    public function exportPdf()
    {
        $members = Member::all();
        $pdf = Pdf::loadView('member.exports.pdf', compact('members'));
        return $pdf->download('data_member.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new GenericExport('members'), 'data_member.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(
            new GenericExport('members'),
            'data_member.csv',
            \Maatwebsite\Excel\Excel::CSV
        );
    }

    public function exportJson()
    {
        $members = Member::all();
        return response()->json([
            'success' => true,
            'data' => $members->map(fn($m) => [
                'id' => $m->id_member,
                'nama' => $m->nama,
                'email' => $m->email,
                'no_hp' => $m->no_hp,
                'saldo' => $m->saldo,
                'status' => $m->status
            ])
        ]);
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        // Proses import (contoh)
        // Excel::import(new MemberImport, $request->file('file'));

        return redirect()->route('member.index')->with('success', 'Import berhasil!');
    }
}
