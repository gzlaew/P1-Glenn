@php
  $user = auth()->user();
  $_is_superadmin = $user && $user->id === 1;
@endphp

@extends('stisla.layouts.app')

@section('title')
  {{ $title = 'Profil' }}
@endsection

@section('content')
  @include('stisla.includes.breadcrumbs.breadcrumb-table')

  <div class="section-body">
    <h2 class="section-title">{{ $title }}</h2>
    <p class="section-lead">{{ __('Perbarui kapan saja profil anda di halaman ini') }}.</p>
    <div class="row">
      <div class="col-md-8">
        <form action="" method="post" enctype="multipart/form-data" class="needs-validation">
          <div class="card">
            <div class="card-header">
              <h4> <i class="fa fa-user"></i> {{ $title }}</h4>
            </div>
            <div class="card-body">
              @method('PUT')
              @csrf
              <div class="row">
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-name', ['value' => $user->name, 'required' => true])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-avatar', ['required' => false])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', [
                      'id' => 'phone_number',
                      'name' => 'phone_number',
                      'label' => __('No HP'),
                      'type' => 'text',
                      'required' => false,
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
                      'icon' => 'fas fa-map-marker-alt',
                  ])
                </div>
                <div class="col-md-12">
                  @include('stisla.includes.forms.buttons.btn-save')
                  @include('stisla.includes.forms.buttons.btn-reset')
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4><i class="fas fa-wallet"></i> Informasi Akun</h4>
            <a href="{{ route('topup.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Isi Saldo</a>
          </div>
          <div class="card-body">
            <p><strong>Saldo:</strong> Rp {{ number_format($user->saldo ?? 0) }}</p>
            <a href="{{ route('history.index') }}" class="btn btn-info mb-3">
            <i class="fas fa-history"></i> Riwayat Saldo
            </a>
            <p><strong>Tanggal Bergabung:</strong> {{ \Carbon\Carbon::parse($user->created_at)->format('d-m-Y') }}</p>
          </div>
        </div>
      </div>

      <div class="col-12">
        <form action="{{ route('profile.update-email') }}" method="post" class="needs-validation" id="formEmail">
          <div class="card">
            <div class="card-header">
              <h4> <i class="fa fa-envelope"></i> {{ __('Perbarui Email') }}</h4>
            </div>
            <div class="card-body">
              @method('PUT')
              @csrf
              <div class="row">
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-email', ['value' => $user->email])
                </div>
                @if (!($_is_superadmin && config('app.is_demo')))
                  <div class="col-md-12">
                    @include('stisla.includes.forms.buttons.btn-save')
                    @include('stisla.includes.forms.buttons.btn-reset')
                  </div>
                @endif
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="col-12">
        <form action="{{ route('profile.update-password') }}" method="post" class="needs-validation" id="formPassword">
          <div class="card">
            <div class="card-header">
              <h4> <i class="fa fa-key"></i> {{ __('Perbarui Password') }}</h4>
            </div>
            <div class="card-body">
              @method('PUT')
              @csrf
              <div class="row">
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-password', ['value' => '', 'id' => 'old_password', 'label' => __('Password Lama')])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-password', ['value' => '', 'id' => 'new_password', 'label' => __('Password Baru')])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-password', ['value' => '', 'id' => 'new_password_confirmation', 'label' => __('Konfirmasi Password Baru')])
                </div>
                @if (!($_is_superadmin && config('app.is_demo')))
                  <div class="col-md-12">
                    @include('stisla.includes.forms.buttons.btn-save')
                    @include('stisla.includes.forms.buttons.btn-reset')
                  </div>
                @endif
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@if ($_is_superadmin && config('app.is_demo'))
  @push('scripts')
    <script>
      $(function() {
        $('#formEmail').find('input').attr('disabled', true)
        $('#formPassword').find('input').attr('disabled', true)
      })
    </script>
  @endpush
@endif
