@extends('stisla.layouts.app')

@section('title', 'Daftar Permintaan Top Up')

@section('content')
<div class="section-header">
  <h1>Daftar Permintaan Top Up Saldo</h1>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('info'))
  <div class="alert alert-info">{{ session('info') }}</div>
@endif

<div class="card">
  <div class="card-body table-responsive">
    <a href="{{ route('topup.pdf') }}" class="btn btn-outline-danger mb-3">
  <i class="fas fa-file-pdf"></i> Export PDF
</a>

    <table class="table table-striped">
<thead>
  <tr>
    <th>No</th>
    <th>Nama</th>
    <th>Jumlah</th>
    <th>Status</th>
    <th>Bukti</th>
    <th>Keterangan</th>
    <th>Tanggal</th>
    @if (!in_array($user->role, ['Member', 'Marketing']))
      <th>Aksi</th>
    @endif
  </tr>
</thead>
<tbody>
  @foreach ($data as $key => $item)
  <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $item->user->name ?? '-' }}</td>
    <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
    <td>{{ ucfirst($item->status) }}</td>
    <td>
      @if ($item->bukti_transfer)
        <a href="{{ asset('storage/' . $item->bukti_transfer) }}" target="_blank">Lihat</a>
      @else
        -
      @endif
    </td>
    <td>{{ $item->keterangan ?? '-' }}</td>
    <td>{{ $item->created_at->format('d-m-Y') }}</td>

    @if (!in_array($user->role, ['Member', 'Marketing']))
    <td>
      @if ($item->status === 'pending')
        <form action="{{ route('topup.approve', $item->id) }}" method="POST" class="d-inline">
          @csrf
          <button class="btn btn-success btn-sm" onclick="return confirm('Setujui top-up ini?')">Setujui</button>
        </form>
        <form action="{{ route('topup.reject', $item->id) }}" method="POST" class="d-inline">
          @csrf
          <button class="btn btn-danger btn-sm" onclick="return confirm('Tolak top-up ini?')">Tolak</button>
        </form>
      @else
        <span class="text-muted">-</span>
      @endif
    </td>
    @endif
  </tr>
  @endforeach
</tbody>

    </table>
  </div>
</div>
@endsection
