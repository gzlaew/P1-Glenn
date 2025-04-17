@php
  $isAjax = false;
  $isYajra = false;
  $isAjaxYajra = false;
@endphp

@extends('stisla.layouts.app-datatable')

@section('breadcrumbs')
  @include('stisla.includes.breadcrumbs.breadcrumb', ['breadcrumbs' => $breadcrumbs])
@endsection

{{-- ✅ FORM TO-DO LIST --}}
@section('rowForm')
<div class="row">
  <div class="col-12">
    {{-- Filter --}}
<form method="GET" action="{{ route('pegawai.index') }}" class="form-inline mb-3">
  <div class="form-group mr-2">
    <select name="role" class="form-control">
      <option value="">-- Filter Role --</option>
      <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
      <option value="Petugas" {{ request('role') == 'Petugas' ? 'selected' : '' }}>Petugas</option>
      <option value="Marketing" {{ request('role') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
      <option value="Member" {{ request('role') == 'Member' ? 'selected' : '' }}>Member</option>
    </select>
  </div>
  <div class="form-group mr-2">
    <select name="created_sort" class="form-control">
      <option value="">-- Urutkan Waktu --</option>
      <option value="latest" {{ request('created_sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
      <option value="oldest" {{ request('created_sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
    </select>
  </div>
  <div class="form-group mr-2">
    <select name="sort_name" class="form-control">
      <option value="">-- Urutkan Nama --</option>
      <option value="asc" {{ request('sort_name') == 'asc' ? 'selected' : '' }}>A-Z</option>
      <option value="desc" {{ request('sort_name') == 'desc' ? 'selected' : '' }}>Z-A</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Terapkan</button>
  <a href="{{ route('pegawai.index') }}" class="btn btn-secondary ml-2">Reset</a>
</form>


    {{-- Form Tambah / Edit --}}
    <form method="POST" action="{{ isset($user) ? $action : route('pegawai.store') }}" class="needs-validation" novalidate>
      @csrf
      @if (isset($user))
        @method('PUT')
        <input type="hidden" name="id" value="{{ $user->id }}">
      @endif

      <div class="row">
        <div class="col-md-6">
          @include('stisla.includes.forms.inputs.input-name', [
            'required' => true,
            'value' => old('name', $user->name ?? '')
          ])
        </div>
        <div class="col-md-6">
          @include('stisla.includes.forms.inputs.input', [
            'id' => 'phone_number',
            'name' => 'phone_number',
            'label' => 'No HP',
            'type' => 'text',
            'value' => old('phone_number', $user->phone_number ?? ''),
            'icon' => 'fas fa-phone'
          ])
        </div>
        <div class="col-md-6">
          @include('stisla.includes.forms.inputs.input', [
            'id' => 'birth_date',
            'name' => 'birth_date',
            'label' => 'Tanggal Lahir',
            'type' => 'date',
            'value' => old('birth_date', $user->birth_date ?? ''),
            'icon' => 'fas fa-calendar'
          ])
        </div>
        <div class="col-md-6">
          @include('stisla.includes.forms.inputs.input', [
            'id' => 'address',
            'name' => 'address',
            'label' => 'Alamat',
            'type' => 'text',
            'value' => old('address', $user->address ?? ''),
            'icon' => 'fas fa-map-marker-alt'
          ])
        </div>
        <div class="col-md-6">
          @include('stisla.includes.forms.inputs.input', [
            'id' => 'saldo',
            'name' => 'saldo',
            'label' => 'Saldo',
            'type' => 'number',
            'value' => old('saldo', $user->saldo ?? 0),
            'icon' => 'fas fa-wallet'
          ])
        </div>
        <div class="col-md-6">
          @include('stisla.includes.forms.inputs.input', [
            'id' => 'tanggal_daftar',
            'name' => 'tanggal_daftar',
            'label' => 'Tanggal Daftar',
            'type' => 'date',
            'value' => old('tanggal_daftar', $user->tanggal_daftar ?? now()->format('Y-m-d')),
            'icon' => 'fas fa-calendar-check'
          ])
        </div>
        <div class="col-md-6">
          @include('stisla.includes.forms.selects.select', [
            'id' => 'role',
            'name' => 'role',
            'label' => 'Role',
            'required' => true,
            'options' => ['Admin' => 'Admin', 'Petugas' => 'Petugas', 'Marketing' => 'Marketing', 'Member' => 'Member'],
            'selected' => old('role', $user->role ?? '')
          ])
        </div>
        <div class="col-md-6">
          @include('stisla.includes.forms.inputs.input-password', [
            'id' => 'password',
            'label' => 'Password',
          ])
          @if(isset($user))
            <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
          @endif
        </div>
        <div class="col-md-6">
          @include('stisla.includes.forms.inputs.input-password', [
            'id' => 'password_confirmation',
            'label' => 'Konfirmasi Password',
          ])
        </div>
      </div>

      <div class="form-group text-right mt-3">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> {{ isset($user) ? 'Update' : 'Simpan' }}
        </button>
        @if (isset($user))
          <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
        @endif
      </div>
    </form>
  </div>
</div>
@endsection


{{-- ✅ TABEL TO-DO LIST --}}
@section('table')
<div class="table-responsive mt-5">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Role</th>
        <th>Saldo</th>
        <th>Tanggal Daftar</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->name }}</td>
        <td>{{ $item->email }}</td>
        <td>{{ $item->role }}</td>
        <td>{{ number_format($item->saldo ?? 0) }}</td>
        <td>{{ $item->created_at->format('d-m-Y') }}</td>
        <td>
          <a href="{{ route('pegawai.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
          <form action="{{ route('pegawai.destroy', $item->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection


@push('css')
@endpush

@push('js')
@endpush

@push('scripts')
@endpush
