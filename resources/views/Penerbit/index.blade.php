@php
  $title = 'Penerbit';
  $moduleIcon = 'fas fa-building';
  $isYajra = true;
@endphp

@extends('stisla.layouts.app-datatable')

@section('breadcrumbs')
  @include('stisla.includes.breadcrumbs.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@section('rowForm')
  <form method="POST" action="{{ isset($penerbit) ? route('penerbit.update', $penerbit->id_penerbit) : route('penerbit.store') }}">
    @csrf
    @if(isset($penerbit)) @method('PUT') @endif

    @include('stisla.includes.forms.inputs.input', [
      'id' => 'nama_penerbit',
      'name' => 'nama_penerbit',
      'label' => 'Nama Penerbit',
      'type' => 'text',
      'required' => true,
      'value' => old('nama_penerbit', $penerbit->nama_penerbit ?? '')
    ])

    <div class="text-right mt-3">
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> {{ isset($penerbit) ? 'Update' : 'Simpan' }}
      </button>
    </div>
  </form>
@endsection

@section('table')
<form method="GET" class="mb-3">
  <div class="row align-items-end">
    <div class="col-md-4">
      <label for="search">Cari Nama Penerbit</label>
      <input type="text" name="search" id="search" class="form-control" placeholder="Contoh: Gramedia" value="{{ request('search') }}">
    </div>

    <div class="col-md-4">
      <label for="sort_name">Urutkan Berdasarkan</label>
      <select name="sort_name" class="form-control">
        <option value="">-- Pilih Urutan --</option>
        <option value="asc" {{ request('sort_name') == 'asc' ? 'selected' : '' }}>Nama A-Z</option>
        <option value="desc" {{ request('sort_name') == 'desc' ? 'selected' : '' }}>Nama Z-A</option>
      </select>
    </div>

    <div class="col-md-4">
      <label for="sort_date">Tanggal Dibuat</label>
      <select name="sort_date" class="form-control">
        <option value="">-- Pilih Waktu --</option>
        <option value="desc" {{ request('sort_date') == 'desc' ? 'selected' : '' }}>Terbaru</option>
        <option value="asc" {{ request('sort_date') == 'asc' ? 'selected' : '' }}>Terlama</option>
      </select>
    </div>
  </div>

  <div class="text-right mt-3">
    <button type="submit" class="btn btn-primary">
      <i class="fas fa-filter"></i> Terapkan
    </button>
  </div>
</form>

<table class="table table-striped mt-3">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Penerbit</th>
      <th>Tanggal Dibuat</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($penerbitList as $item)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $item->nama_penerbit }}</td>
      <td>{{ $item->created_at->format('d-m-Y') }}</td>
      <td>
        <a href="{{ route('penerbit.edit', $item->id_penerbit) }}" class="btn btn-warning btn-sm">Edit</a>
        <form action="{{ route('penerbit.destroy', $item->id_penerbit) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button onclick="return confirm('Hapus?')" class="btn btn-danger btn-sm">Hapus</button>
        </form>
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="4" class="text-center">Tidak ada data</td>
    </tr>
    @endforelse
  </tbody>
</table>
@endsection

