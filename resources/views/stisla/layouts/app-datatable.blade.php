@php
  $isYajra = $isYajra ?? false;
  $isAjax = $isAjax ?? false;
  $isAjaxYajra = $isAjaxYajra ?? false;
  $canExport = $canExport ?? false;
  $canCreate = $canCreate ?? false;
  $canImportExcel = $canImportExcel ?? false;
  $moduleIcon = $moduleIcon ?? 'fas fa-database';
  $route_create = $route_create ?? '#';
  $routePdf = $routePdf ?? '#';
  $routeExcel = $routeExcel ?? '#';
  $routeCsv = $routeCsv ?? '#';
  $routeJson = $routeJson ?? '#';
  $routeImportExcel = $routeImportExcel ?? '#';
  $routeExampleExcel = $routeExampleExcel ?? '';
@endphp

@extends($data->count() > 0 || $isYajra || $isAjaxYajra ? 'stisla.layouts.app-table' : 'stisla.layouts.app')

@section('title', $title)

@section('content')
  @include('stisla.includes.breadcrumbs.breadcrumb-table')

  <div class="section-body">
    <h2 class="section-title">{{ $title }}</h2>
    <p class="section-lead">{{ __('Menampilkan halaman ' . $title) }}.</p>
    <div class="row">
      <div class="col-12">

        @if ($data->count() > 0 || $isYajra || $isAjaxYajra)

          @if ($canExport)
            <div class="card">
              <div class="card-header">
                <h4><i class="{{ $moduleIcon }}"></i> {!! __('Aksi Ekspor <small>(Server Side)</small>') !!}</h4>
                <div class="card-header-action">
                  @include('stisla.includes.forms.buttons.btn-pdf-download', ['link' => $routePdf])
                  @include('stisla.includes.forms.buttons.btn-excel-download', ['link' => $routeExcel])
                  @include('stisla.includes.forms.buttons.btn-csv-download', ['link' => $routeCsv])
                  @include('stisla.includes.forms.buttons.btn-json-download', ['link' => $routeJson])
                </div>
              </div>
            </div>
          @endif

          <div class="card">
            <div class="card-header">
              <h4><i class="{{ $moduleIcon }}"></i> Data {{ $title }}</h4>
              <div class="card-header-action">
                @if ($canImportExcel)
                  @include('stisla.includes.forms.buttons.btn-import-excel')
                @endif
                @if ($canCreate)
                  @include('stisla.includes.forms.buttons.btn-add', ['link' => $route_create])
                @endif
              </div>
            </div>
            <div class="card-body">
              @yield('rowForm')
              @include('stisla.includes.forms.buttons.btn-datatable')
              <div class="table-responsive" id="datatable-view">
                <input type="hidden" id="isYajra" value="{{ $isYajra }}">
                <input type="hidden" id="isAjax" value="{{ $isAjax }}">
                <input type="hidden" id="isAjaxYajra" value="{{ $isAjaxYajra }}">
                @if ($isYajra || $isAjaxYajra)
                  <textarea name="yajraColumns" id="yajraColumns" cols="30" rows="10" style="display: none;">{!! $yajraColumns ?? '' !!}</textarea>
                @endif
                @yield('table')
              </div>
            </div>
          </div>

        @else
          @include('stisla.includes.others.empty-state', [
              'title' => 'Data ' . $title,
              'icon' => $moduleIcon,
              'link' => $route_create,
          ])
        @endif

      </div>
    </div>
  </div>
@endsection
@push('styles')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(document).ready(function () {
      $('select[name="id_kategori"]').select2({ placeholder: 'Pilih Kategori' });
      $('select[name="id_penerbit"]').select2({ placeholder: 'Pilih Penerbit' });
      $('select[name="id_pengarang"]').select2({ placeholder: 'Pilih Pengarang' });
    });
  </script>
@endpush

@push('modals')
  @if ($canImportExcel)
    @include('stisla.includes.modals.modal-import-excel', [
        'formAction' => $routeImportExcel,
        'downloadLink' => $routeExampleExcel,
    ])
  @endif
@endpush
