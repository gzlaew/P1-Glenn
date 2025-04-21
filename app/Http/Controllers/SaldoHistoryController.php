<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaldoHistory;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SaldoHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $riwayat = SaldoHistory::where('user_id', $user->id)->latest()->get();

        return view('saldo_topup.history', [
            'data' => $riwayat, // ubah dari 'riwayat' ke 'data'
            'title' => 'Riwayat Saldo',
            'canExport' => false,
            'canCreate' => false,
            'moduleIcon' => 'fas fa-history',
        ]);
    }
    public function exportPdf(Request $request)
    {
        $tipe = $request->query('tipe');

        $query = SaldoHistory::query();

        if ($tipe) {
            $query->where('tipe', $tipe);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('saldo_topup.exports.history_pdf', compact('data', 'tipe'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('riwayat_saldo.pdf');
    }

    public static function catat($tipe, $jumlah, $keterangan = null, $userId = null)
    {
        SaldoHistory::create([
            'user_id'    => $userId ?? Auth::id(),
            'tipe'       => $tipe, // 'topup', 'peminjaman', 'denda'
            'jumlah'     => $jumlah,
            'keterangan' => $keterangan,
            'created_at' => now(),
        ]);
    }
}
