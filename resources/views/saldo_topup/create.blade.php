@extends('stisla.layouts.app')

@section('title', 'Form Top Up Saldo')

@section('content')
<div class="section-header">
  <h1>Form Top Up Saldo</h1>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
  <div class="card-body">
   <form method="POST" action="{{ route('topup.store') }}" enctype="multipart/form-data">
      @csrf

    <div class="form-group">
    <label for="jumlah">Jumlah Top Up <span class="text-danger">*</span></label>
<input type="text" class="form-control" id="jumlah" name="jumlah" required>
    </div>

      <div class="form-group">
        <label for="bukti_transfer">Upload Bukti Transfer <span class="text-danger">*</label>
       <input type="file" name="bukti_transfer" id="bukti_transfer" class="form-control-file" required>
      </div>

      <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <textarea name="keterangan" id="keterangan" placeholder="Contoh : Atas nama Syahrini" class="form-control">{{ old('keterangan') }}</textarea>
      </div>

      <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
    </form>
  </div>
</div>
@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const input = document.getElementById('jumlah');

  input.addEventListener('input', function (e) {
    let value = this.value.replace(/,/g, '').replace(/[^\d]/g, '');
    if (value) {
      this.value = parseInt(value).toLocaleString('id-ID');
    } else {
      this.value = '';
    }
  });

  const form = input.closest('form');
  form.addEventListener('submit', function () {
    input.value = input.value.replace(/,/g, '');
  });
});
</script>
@endpush


