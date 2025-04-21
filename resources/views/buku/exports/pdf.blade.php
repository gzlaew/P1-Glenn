<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Buku</title>
  <style>
    body {
      font-family: sans-serif;
      font-size: 12px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    th, td {
      border: 1px solid #444;
      padding: 6px;
      text-align: left;
    }
    th {
      background-color: #f0f0f0;
    }
    h2 {
      text-align: center;
      margin-bottom: 0;
    }
  </style>
</head>
<body>
  <h2>Data Buku</h2>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Kategori</th>
        <th>Penerbit</th>
        <th>Pengarang</th>
        <th>Stok</th>
        <th>Ukuran</th>
        <th>Harga</th>
        <th>Harga Pinjam</th>
        <th>Denda / Jam</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $key => $item)
      <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $item->judul }}</td>
        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
        <td>{{ $item->penerbit->nama_penerbit ?? '-' }}</td>
        <td>{{ $item->pengarang->nama_pengarang ?? '-' }}</td>
        <td>{{ $item->stok }}</td>
        <td>{{ $item->size ?? '-' }}</td>
        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
        <td>Rp {{ number_format($item->harga_pinjam, 0, ',', '.') }}</td>
        <td>Rp {{ number_format($item->denda, 0, ',', '.') }}</td>
        <td>{{ ucfirst($item->status) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
