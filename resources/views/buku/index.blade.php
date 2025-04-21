@extends('stisla.layouts.app-datatable')

@section('title', 'Manajemen Buku')

@section('content')
<div class="section-header">
  <h1>Manajemen Buku</h1>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
  <div class="alert alert-danger">
    <strong>Terjadi kesalahan:</strong>
    <ul class="mb-0">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ isset($buku) ? route('buku.update', $buku->id_buku) : route('buku.store') }}" enctype="multipart/form-data">
      @csrf
      @if(isset($buku))
        @method('PUT')
      @endif

      <div class="row">
        <div class="col-md-6">
          <label for="judul">Judul Buku</label>
          <input type="text" name="judul" class="form-control" value="{{ old('judul', $buku->judul ?? '') }}">
          @error('judul') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6">
          <label for="id_kategori">Kategori</label>
          <select name="id_kategori" class="form-control select2">
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategori as $item)
              <option value="{{ $item->id_kategori }}" {{ old('id_kategori', $buku->id_kategori ?? '') == $item->id_kategori ? 'selected' : '' }}>
                {{ $item->nama_kategori }}
              </option>
            @endforeach
          </select>
          @error('id_kategori') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6">
          <label for="id_penerbit">Penerbit</label>
          <select name="id_penerbit" class="form-control select2">
            <option value="">-- Pilih Penerbit --</option>
            @foreach($penerbit as $item)
              <option value="{{ $item->id_penerbit }}" {{ old('id_penerbit', $buku->id_penerbit ?? '') == $item->id_penerbit ? 'selected' : '' }}>
                {{ $item->nama_penerbit }}
              </option>
            @endforeach
          </select>
          @error('id_penerbit') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6">
          <label for="id_pengarang">Pengarang</label>
          <select name="id_pengarang" class="form-control select2">
            <option value="">-- Pilih Pengarang --</option>
            @foreach($pengarang as $item)
              <option value="{{ $item->id_pengarang }}" {{ old('id_pengarang', $buku->id_pengarang ?? '') == $item->id_pengarang ? 'selected' : '' }}>
                {{ $item->nama_pengarang }}
              </option>
            @endforeach
          </select>
          @error('id_pengarang') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-4">
          <label for="stok">Stok Buku</label>
          <input type="number" name="stok" class="form-control" value="{{ old('stok', $buku->stok ?? 0) }}">
          @error('stok') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-4">
          <label for="harga">Harga Buku</label>
          <input type="number" name="harga" class="form-control" value="{{ old('harga', $buku->harga ?? 0) }}">
          @error('harga') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-4">
          <label for="harga_pinjam">Harga Pinjam</label>
          <input type="number" name="harga_pinjam" class="form-control" value="{{ old('harga_pinjam', $buku->harga_pinjam ?? 0) }}">
          @error('harga_pinjam') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6">
          <label for="denda">Denda per Jam (telat)</label>
          <input type="number" name="denda" class="form-control" value="{{ old('denda', $buku->denda ?? 0) }}">
          @error('denda') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6">
          <label for="file_pdf">Upload File Buku</label>
          <small class="text-muted d-block mb-1">Bisa upload file apapun, maksimal 50MB</small>
          <input type="file" name="file_pdf" class="form-control">
          @error('file_pdf') <small class="text-danger">{{ $message }}</small> @enderror
          @if(isset($buku) && $buku->file_pdf)
            <small><a href="{{ asset('storage/' . $buku->file_pdf) }}" target="_blank">Lihat File Saat Ini</a></small>
          @endif
        </div>

        <div class="col-md-6">
          <label for="size">Ukuran</label>
          <input type="text" name="size" class="form-control" readonly value="{{ old('size', $buku->size ?? '') }}">
          @error('size') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6">
          <label for="status">Status</label>
          <select name="status" class="form-control">
            <option value="tersedia" {{ old('status', $buku->status ?? '') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="tidak tersedia" {{ old('status', $buku->status ?? '') == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
          </select>
          @error('status') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
      </div>

      <div class="form-group mt-3 text-right">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> {{ isset($buku) ? 'Update' : 'Simpan' }}
        </button>
        @if(isset($buku))
          <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
        @endif
      </div>
    </form>
  </div>
</div>

<div class="card mt-4">
  <div class="card-header">
    <h4>Daftar Buku</h4>
    <div class="card-header-action">
      <a href="{{ route('buku.exportPdf') }}" class="btn btn-danger">
        <i class="fas fa-file-pdf"></i> Export PDF
      </a>
    </div>
  </div>
  <div class="card-body table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Judul</th>
          <th>Kategori</th>
          <th>Penerbit</th>
          <th>Pengarang</th>
          <th>Stok</th>
          <th>Harga</th>
          <th>Harga Pinjam</th>
          <th>Denda</th>
          <th>Ukuran</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->judul }}</td>
          <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
          <td>{{ $item->penerbit->nama_penerbit ?? '-' }}</td>
          <td>{{ $item->pengarang->nama_pengarang ?? '-' }}</td>
          <td>{{ $item->stok }}</td>
          <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
          <td>Rp {{ number_format($item->harga_pinjam, 0, ',', '.') }}</td>
          <td>Rp {{ number_format($item->denda, 0, ',', '.') }}</td>
          <td>{{ $item->size }}</td>
          <td>{{ ucfirst($item->status) }}</td>
          <td>
          <a href="{{ url('buku?edit=' . $item->id_buku) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('buku.destroy', $item->id_buku) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  $('.select2').select2();

  const fileInput = document.querySelector('input[name="file_pdf"]');
  const sizeInput = document.querySelector('input[name="size"]');

  fileInput?.addEventListener('change', function () {
    if (this.files.length > 0) {
      const file = this.files[0];
      const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
      sizeInput.value = `${fileSizeMB} MB`;
    } else {
      sizeInput.value = '';
    }
  });
});
</script>
@endpush
