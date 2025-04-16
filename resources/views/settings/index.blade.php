@extends('stisla.layouts.app')

@section('title', 'Pengaturan Aplikasi')

@section('content')
<div class="section-header">
  <h1>Pengaturan Aplikasi</h1>
</div>

@if (session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('setting.update') }}" method="POST">
  @csrf
  <div class="card">
    <div class="card-body row">
      @php
        $val = fn($key) => $settings[$key] ?? '';
      @endphp

      <div class="col-md-6">
        @include('stisla.includes.forms.inputs.input', ['id' => 'application_name', 'label' => 'Nama Aplikasi', 'value' => $val('application_name')])
      </div>

      <div class="col-md-6">
        @include('stisla.includes.forms.inputs.input', ['id' => 'company_name', 'label' => 'Nama Perpustakaan', 'value' => $val('company_name')])
      </div>

      <div class="col-md-12">
        @include('stisla.includes.forms.inputs.input', ['id' => 'alamat', 'label' => 'Alamat', 'value' => $val('alamat')])
      </div>

      <div class="col-md-6">
        @include('stisla.includes.forms.inputs.input', ['id' => 'kontak', 'label' => 'Kontak', 'value' => $val('kontak')])
      </div>

      <div class="col-md-4">
        @include('stisla.includes.forms.inputs.input', ['id' => 'biaya_pendaftaran', 'label' => 'Biaya Pendaftaran', 'type' => 'number', 'value' => $val('biaya_pendaftaran')])
      </div>

      <div class="col-md-4">
        @include('stisla.includes.forms.inputs.input', ['id' => 'biaya_peminjaman', 'label' => 'Biaya Peminjaman', 'type' => 'number', 'value' => $val('biaya_peminjaman')])
      </div>

      <div class="col-md-4">
        @include('stisla.includes.forms.inputs.input', ['id' => 'biaya_keterlambatan', 'label' => 'Biaya Keterlambatan', 'type' => 'number', 'value' => $val('biaya_keterlambatan')])
      </div>

      <div class="col-md-12">
        @include('stisla.includes.forms.inputs.input', ['id' => 'logo', 'label' => 'Link Logo', 'value' => $val('logo')])
      </div>

      <div class="col-12 mt-4 text-right">
        @include('stisla.includes.forms.buttons.btn-save')
      </div>
    </div>
  </div>
</form>
@endsection
