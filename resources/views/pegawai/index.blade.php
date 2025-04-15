@php
  $isAjax = $isAjax ?? false;
@endphp
@include('stisla.includes.breadcrumbs.breadcrumb', ['breadcrumbs' => $breadcrumbs])

@extends('stisla.layouts.app-form')

@section('rowForm')
  <div class="row">
    <div class="col-12">
      {{-- Jika sedang mode edit, tampilkan method PUT --}}
      @if (isset($user))
        @method('PUT')
      @endif
<form method="POST" action="{{ isset($user) ? $action : route('pegawai.store') }}" class="needs-validation" novalidate="">
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
                'label' => __('No HP'),
                'type' => 'number',
                'required' => false,
                'value' => old('phone_number', $user->phone_number ?? ''),
                'icon' => 'fas fa-phone',
            ])
          </div>

          <div class="col-md-6">
            @include('stisla.includes.forms.inputs.input', [
                'id' => 'birth_date',
                'name' => 'birth_date',
                'label' => __('Tanggal Lahir'),
                'type' => 'date',
                'required' => false,
                'value' => old('birth_date', $user->birth_date ?? ''),
                'icon' => 'fas fa-calendar',
            ])
          </div>
          <div class="col-md-6">
            @include('stisla.includes.forms.inputs.input', [
                'id' => 'address',
                'name' => 'address',
                'label' => __('Alamat'),
                'type' => 'text',
                'required' => false,
                'value' => old('address', $user->address ?? ''),
                'icon' => 'fas fa-map-marker-alt',
            ])
          </div>

          <div class="col-md-6">
            @include('stisla.includes.forms.inputs.input-email', [
                'value' => old('email', $user->email ?? ''),
            ])
          </div>
          <div class="col-md-6">
            @include('stisla.includes.forms.selects.select', [
                'id' => 'role',
                'name' => 'role',
                'label' => 'Role',
                'required' => true,
                'options' => ['Admin' => 'Admin', 'Petugas' => 'Petugas', 'Marketing' => 'Marketing'],
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

        <div class="form-group text-right">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ isset($user) ? 'Update' : 'Simpan' }}
          </button>
          @if(isset($user))
            <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
          @endif
        </div>
      </form>
    </div>
  </div>
@endsection

@section('table')
  <div class="table-responsive mt-5">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Role</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($users as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->role }}</td>
            <td>
              <a href="{{ route('pegawai.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
              <form action="{{ route('pegawai.destroy', $item->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
        @endforelse
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
