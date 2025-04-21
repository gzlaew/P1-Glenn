<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaldoTopupRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\SaldoHistoryController;

class SaldoTopupController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $data = in_array($user->role, ['Member', 'Marketing'])
            ? SaldoTopupRequest::where('user_id', $user->id)->latest()->get()
            : SaldoTopupRequest::with('user')->latest()->get();

        return view('saldo_topup.index', compact('data', 'user'));
    }

    public function create()
    {
        return view('saldo_topup.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|string',
            'bukti_transfer' => 'required|image|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        $jumlah = (int) str_replace(['.', ','], '', $request->jumlah);

        if (!$request->hasFile('bukti_transfer')) {
            return back()->withErrors(['bukti_transfer' => 'Bukti transfer belum dipilih.']);
        }

        $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');

        SaldoTopupRequest::create([
            'user_id' => Auth::id(),
            'jumlah' => $jumlah,
            'bukti_transfer' => $path,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('topup.index')->with('success', 'Permintaan top-up berhasil dikirim.');
    }

    public function approve($id)
    {
        $topup = SaldoTopupRequest::findOrFail($id);

        // Hindari double approve
        if ($topup->status === 'disetujui') {
            return back()->with('info', 'Permintaan ini sudah disetujui sebelumnya.');
        }

        $topup->update(['status' => 'disetujui']);
        $topup->user->increment('saldo', $topup->jumlah);

        // ✅ Catat riwayat topup
        SaldoHistoryController::catat(
            'topup',
            $topup->jumlah,
            'Topup disetujui oleh admin',
            $topup->user_id
        );

        return back()->with('success', 'Top up disetujui.');
    }

    public function reject($id)
    {
        $topup = SaldoTopupRequest::findOrFail($id);
        $topup->update(['status' => 'ditolak']);

        return back()->with('info', 'Top up ditolak.');
    }

    public function exportPdf()
    {
        $this->authorize('viewAny', SaldoTopupRequest::class); // jika pakai policy

        $requests = SaldoTopupRequest::with('user')->latest()->get();

        $pdf = Pdf::loadView('saldo_topup.exports.pdf', compact('requests'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('daftar_topup_saldo.pdf');
    }
}
