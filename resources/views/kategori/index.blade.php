@php
  $title = $title ?? 'Kategori';
  $moduleIcon = 'fas fa-tags';
  $routeIndex = route('kategori.index');
  $route_create = route('kategori.index');
  $routePdf = route('kategori.pdf');
  $routeExcel = route('kategori.excel');
  $routeCsv = route('kategori.csv');
  $routeJson = route('kategori.json');
  $routeImportExcel = '#';
  $routeExampleExcel = '#';
  $canCreate = $canCreate ?? true;
  $canExport = $canExport ?? true;
  $canImportExcel = $canImportExcel ?? false;
  $isAjax = false;
  $isYajra = true;
  $isAjaxYajra = false;
@endphp

@extends('stisla.layouts.app-datatable')

@section('title', $title)

@section('breadcrumbs')
  @include('stisla.includes.breadcrumbs.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

@section('rowForm')
  <div class="row">
    <div class="col-12">
      <form method="POST" action="{{ isset($kategori) ? route('kategori.update', $kategori->id_kategori) : route('kategori.store') }}" class="needs-validation" novalidate>
        @csrf
        @if (isset($kategori))
          @method('PUT')
        @endif

        <div class="row">
          <div class="col-md-12">
            @include('stisla.includes.forms.inputs.input', [
              'id' => 'nama_kategori',
              'name' => 'nama_kategori',
              'label' => 'Nama Kategori',
              'type' => 'text',
              'required' => true,
              'value' => old('nama_kategori', $kategori->nama_kategori ?? '')
            ])
          </div>
        </div>

        <div class="form-group text-right mt-3">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ isset($kategori) ? 'Update' : 'Simpan' }}
          </button>
          @if (isset($kategori))
            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
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
          <label for="search">Cari Nama Kategori</label>
          <input type="text" name="search" id="search" class="form-control" placeholder="Cari Nama Kategori" value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
          <label for="sort_name">Urutkan Nama</label>
          <select name="sort_name" id="sort_name" class="form-control">
            <option value="">-- Pilih --</option>
            <option value="asc" {{ request('sort_name') == 'asc' ? 'selected' : '' }}>A - Z</option>
            <option value="desc" {{ request('sort_name') == 'desc' ? 'selected' : '' }}>Z - A</option>
          </select>
        </div>

        <div class="col-md-3">
          <label for="sort_date">Urutkan Tanggal</label>
          <select name="sort_date" id="sort_date" class="form-control">
            <option value="">-- Pilih --</option>
            <option value="desc" {{ request('sort_date') == 'desc' ? 'selected' : '' }}>Terbaru</option>
            <option value="asc" {{ request('sort_date') == 'asc' ? 'selected' : '' }}>Terlama</option>
          </select>
        </div>

        <div class="col-md-2">
          <button type="submit" class="btn btn-primary mt-4">
            <i class="fas fa-filter"></i> Terapkan
          </button>
        </div>
      </div>
    </form>

    <table class="table table-striped mt-3">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Kategori</th>
          <th>Tanggal Dibuat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($kategoriList as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama_kategori }}</td>
            <td>{{ $item->created_at->format('d-m-Y') }}</td>
            <td>
              <a href="{{ route('kategori.edit', $item->id_kategori) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form action="{{ route('kategori.destroy', $item->id_kategori) }}" method="POST" class="d-inline">
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
