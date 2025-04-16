@php
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
      {{-- Jika sedang mode edit, tampilkan method PUT --}}
      @if (isset($member))
        @method('PUT')
      @endif
      <form method="POST" action="{{ isset($member) ? $action : route('member.store') }}" class="needs-validation" novalidate="">
        @csrf
        @if (isset($member))
          @method('PUT')
          <input type="hidden" name="id_member" value="{{ $member->id_member }}">
        @endif

        <div class="row">
          <div class="col-md-6">
            @include('stisla.includes.forms.inputs.input', [
              'id' => 'nama',
              'name' => 'nama',
              'label' => 'Nama',
              'type' => 'text',
              'required' => true,
              'value' => old('nama', $member->nama ?? '')
            ])
          </div>
          <div class="col-md-6">
            @include('stisla.includes.forms.inputs.input-email', [
              'value' => old('email', $member->email ?? '')
            ])
          </div>
          <div class="col-md-6">
            @include('stisla.includes.forms.inputs.input', [
              'id' => 'no_hp',
              'name' => 'no_hp',
              'label' => 'No HP',
              'type' => 'text',
              'required' => false,
              'value' => old('no_hp', $member->no_hp ?? ''),
              'icon' => 'fas fa-phone'
            ])
          </div>
          <div class="col-md-6">
            @include('stisla.includes.forms.inputs.input', [
              'id' => 'saldo',
              'name' => 'saldo',
              'label' => 'Saldo',
              'type' => 'number',
              'required' => false,
              'value' => old('saldo', $member->saldo ?? '')
            ])
          </div>
          <div class="col-md-6">
            @include('stisla.includes.forms.inputs.input', [
              'id' => 'tanggal_daftar',
              'name' => 'tanggal_daftar',
              'label' => 'Tanggal Daftar',
              'type' => 'date',
              'required' => false,
              'value' => old('tanggal_daftar', $member->tanggal_daftar ?? '')
            ])
          </div>
          <div class="col-md-6">
            @include('stisla.includes.forms.selects.select', [
              'id' => 'status',
              'name' => 'status',
              'label' => 'Status',
              'required' => true,
              'options' => ['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif'],
              'selected' => old('status', $member->status ?? '')
            ])
          </div>
        </div>

        <div class="form-group text-right">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ isset($member) ? 'Update' : 'Simpan' }}
          </button>
          @if(isset($member))
            <a href="{{ route('member.index') }}" class="btn btn-secondary">Batal</a>
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
          <th>No HP</th>
          <th>Saldo</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($members as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->no_hp }}</td>
            <td>{{ number_format($item->saldo) }}</td>
            <td>{{ ucfirst($item->status) }}</td>
            <td>
              <a href="{{ route('member.edit', $item->id_member) }}" class="btn btn-warning btn-sm">Edit</a>
              <form action="{{ route('member.destroy', $item->id_member) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center">Tidak ada data</td></tr>
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
