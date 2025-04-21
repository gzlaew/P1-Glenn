@extends('stisla.layouts.app-datatable')

@section('title', 'Riwayat Saldo')

@section('content')
<div class="section-header">
  <h1>Riwayat Saldo</h1>
</div>

<div class="card">
  <div class="card-body">

    {{-- Saldo Saat Ini --}}
    <div class="alert alert-info">
      <strong>Saldo Saat Ini:</strong>
      Rp {{ number_format(Auth::user()->saldo, 0, ',', '.') }}
    </div>

    {{-- Filter --}}
    <form method="GET" class="mb-4">
      <div class="row">
        <div class="col-md-4">
          <label for="tipe">Filter Tipe</label>
          <select name="tipe" id="tipe" class="form-control">
            <option value="">-- Semua Tipe --</option>
            <option value="topup" {{ request('tipe') == 'topup' ? 'selected' : '' }}>Topup</option>
            <option value="peminjaman" {{ request('tipe') == 'peminjaman' ? 'selected' : '' }}>Peminjaman</option>
            <option value="denda" {{ request('tipe') == 'denda' ? 'selected' : '' }}>Denda</option>
          </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="submit" class="btn btn-primary">Terapkan</button>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <a href="{{ route('history.exportPdf', ['tipe' => request('tipe')]) }}" class="btn btn-danger mb-3">
            <i class="fas fa-file-pdf"></i> Export PDF
          </a>
        </div>
      </div>
    </form>

    {{-- Info filter aktif --}}
    @if(request('tipe'))
      <p><strong>Filter aktif:</strong> {{ ucfirst(request('tipe')) }}</p>
    @endif

    {{-- Tabel Riwayat --}}
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Waktu</th>
            <th>Tipe</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($data as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
            <td>
              @if($item->tipe == 'topup')
                <span class="badge badge-success">Topup</span>
              @elseif($item->tipe == 'peminjaman')
                <span class="badge badge-warning">Peminjaman</span>
              @else
                <span class="badge badge-danger">Denda</span>
              @endif
            </td>
            <td>
              @if($item->tipe == 'topup')
                <span class="text-success">+Rp {{ number_format($item->jumlah, 0, ',', '.') }}</span>
              @else
                <span class="text-danger">-Rp {{ number_format($item->jumlah, 0, ',', '.') }}</span>
              @endif
            </td>
            <td>{{ $item->keterangan ?? '-' }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center">Belum ada riwayat saldo</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>
</div>
@endsection
