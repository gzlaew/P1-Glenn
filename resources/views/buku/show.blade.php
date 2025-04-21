@extends('stisla.layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="section-header">
  <h1>Daftar Buku</h1>
</div>

<div class="row">
  @foreach ($data as $buku)
  <div class="col-md-4 col-sm-6 mb-4">
    <div class="card h-100 shadow-sm">
      <div class="card-body">
        <h5 class="card-title font-weight-bold">{{ $buku->judul }}</h5>
        <p class="card-text mb-1"><strong>Kategori:</strong> {{ $buku->kategori->nama_kategori ?? '-' }}</p>
        <p class="card-text mb-1"><strong>Penerbit:</strong> {{ $buku->penerbit->nama_penerbit ?? '-' }}</p>
        <p class="card-text mb-1"><strong>Pengarang:</strong> {{ $buku->pengarang->nama_pengarang ?? '-' }}</p>
        <p class="card-text mb-1"><strong>Ukuran:</strong> {{ $buku->size ?? '-' }}</p>
        <p class="card-text mb-1"><strong>Harga:</strong> Rp {{ number_format($buku->harga) }}</p>
        <p class="card-text mb-1"><strong>Harga Pinjam:</strong> Rp {{ number_format($buku->harga_pinjam) }}</p>
        <p class="card-text mb-1"><strong>Denda per Jam:</strong> Rp {{ number_format($buku->denda) }}</p>
        <p class="card-text"><strong>Status:</strong>
          <span class="badge badge-{{ $buku->status == 'tersedia' ? 'success' : 'secondary' }}">
            {{ ucfirst($buku->status) }}
          </span>
        </p>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection
