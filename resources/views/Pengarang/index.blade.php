@php
  $title = $title ?? 'Pengarang';
  $moduleIcon = 'fas fa-feather-alt';

  $routeIndex = route('pengarang.index');
  $route_create = route('pengarang.index');
  $routePdf = route('pengarang.pdf');
  $routeExcel = route('pengarang.excel');
  $routeCsv = route('pengarang.csv');
  $routeJson = route('pengarang.json');
  $routeImportExcel = '#';
  $routeExampleExcel = '';

  $canCreate = $canCreate ?? true;
  $canExport = $canExport ?? true;
  $canImportExcel = $canImportExcel ?? false;

  $isAjax = false;
  $isYajra = true;
  $isAjaxYajra = false;
@endphp

@extends('stisla.layouts.app-datatable')

@section('breadcrumbs')
  @include('stisla.includes.breadcrumbs.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@section('rowForm')
  <div class="row">
    <div class="col-12">
      <form method="POST" action="{{ isset($pengarang) ? route('pengarang.update', $pengarang->id_pengarang) : route('pengarang.store') }}" class="needs-validation" novalidate>
        @csrf
        @if (isset($pengarang))
          @method('PUT')
        @endif

        <div class="row">
          <div class="col-md-12">
            @include('stisla.includes.forms.inputs.input', [
              'id' => 'nama_pengarang',
              'name' => 'nama_pengarang',
              'label' => 'Nama Pengarang',
              'type' => 'text',
              'required' => true,
              'value' => old('nama_pengarang', $pengarang->nama_pengarang ?? '')
            ])
          </div>
        </div>

        <div class="form-group text-right mt-3">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ isset($pengarang) ? 'Update' : 'Simpan' }}
          </button>
          @if (isset($pengarang))
            <a href="{{ route('pengarang.index') }}" class="btn btn-secondary">Batal</a>
          @endif
        </div>
      </form>
    </div>
  </div>
@endsection

@section('table')
  <div class="table-responsive mt-4">
    <form method="GET" class="mb-3">
      <div class="row align-items-end">
        <div class="col-md-4">
          <label for="search">Cari Nama Pengarang</label>
          <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Contoh: Tere Liye">
        </div>
        <div class="col-md-3">
          <label for="sort">Urutkan Berdasarkan</label>
          <select name="sort" id="sort" class="form-control">
            <option value="">-- Pilih Urutan --</option>
            <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>Nama A - Z</option>
            <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>Nama Z - A</option>
            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
            <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
          </select>
        </div>
        <div class="col-md-2 mt-4">
          <button type="submit" class="btn btn-primary w-100">
            <i class="fas fa-filter"></i> Terapkan
          </button>
        </div>
      </div>
    </form>

    <table class="table table-striped mt-3">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Pengarang</th>
          <th>Tanggal Dibuat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($pengarangList as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama_pengarang }}</td>
            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
            <td>
              <a href="{{ route('pengarang.edit', $item->id_pengarang) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form action="{{ route('pengarang.destroy', $item->id_pengarang) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                  <i class="fas fa-trash"></i> Hapus
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted">Tidak ada data</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
