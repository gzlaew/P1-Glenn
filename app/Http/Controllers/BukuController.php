<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Pengarang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $data = Buku::with(['kategori', 'penerbit', 'pengarang'])->get();
        $kategori = Kategori::all();
        $penerbit = Penerbit::all();
        $pengarang = Pengarang::all();

        $buku = null;
        if ($request->has('edit')) {
            $buku = Buku::find($request->edit);
        }

        return view('buku.index', [
            'data' => $data,
            'kategori' => $kategori,
            'penerbit' => $penerbit,
            'pengarang' => $pengarang,
            'buku' => $buku,
            'title' => 'Manajemen Buku',
            'canExport' => true,
            'moduleIcon' => 'fas fa-book',
            'routePdf' => route('buku.exportPdf'),
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string',
            'id_kategori' => 'required|exists:tb_kategori,id_kategori',
            'id_penerbit' => 'required|exists:tb_penerbit,id_penerbit',
            'id_pengarang' => 'required|exists:tb_pengarang,id_pengarang',
            'stok' => 'required|integer|min:0',
            'harga_pinjam' => 'required|integer|min:0',
            'harga' => 'required|integer|min:0',
            'denda' => 'required|integer|min:0',
            'size' => 'required|string',
            'status' => 'required|string',
            'file_pdf' => 'nullable|file|max:51200'
        ]);

        if (!$request->hasFile('file_pdf')) {
            $validated['file_pdf'] = null;
        } else {
            $validated['file_pdf'] = $request->file('file_pdf')->store('file_buku', 'public');
        }

        Buku::create($validated);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $data = Buku::with(['kategori', 'penerbit', 'pengarang'])->get();
        $kategori = Kategori::all();
        $penerbit = Penerbit::all();
        $pengarang = Pengarang::all();

        return view('buku.index', [
            'data' => $data,
            'buku' => $buku,
            'kategori' => $kategori,
            'penerbit' => $penerbit,
            'pengarang' => $pengarang,
            'title' => 'Manajemen Buku',
            'canExport' => true,
            'moduleIcon' => 'fas fa-book',
            'routePdf' => route('buku.exportPdf'),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string',
            'id_kategori' => 'required|exists:tb_kategori,id_kategori',
            'id_penerbit' => 'required|exists:tb_penerbit,id_penerbit',
            'id_pengarang' => 'required|exists:tb_pengarang,id_pengarang',
            'stok' => 'required|integer|min:0',
            'harga_pinjam' => 'required|integer|min:0',
            'harga' => 'required|integer|min:0',
            'denda' => 'required|integer|min:0',
            'size' => 'required|string',
            'status' => 'required|string',
            'file_pdf' => 'nullable|file|max:51200'
        ]);

        $buku = Buku::findOrFail($id);

        if ($request->hasFile('file_pdf')) {
            if ($buku->file_pdf) {
                Storage::disk('public')->delete($buku->file_pdf);
            }

            $validated['file_pdf'] = $request->file('file_pdf')->store('file_buku', 'public');
        }

        $buku->update($validated);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        if ($buku->file_pdf) {
            Storage::disk('public')->delete($buku->file_pdf);
        }
        $buku->delete();

        return back()->with('success', 'Data buku berhasil dihapus');
    }

    public function exportPdf()
    {
        $data = Buku::with(['kategori', 'penerbit', 'pengarang'])->get();

        $pdf = Pdf::loadView('buku.exports.pdf', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream('daftar_buku.pdf');
    }
}
