<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Laporan Riwayat Saldo</title>
  <style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    th { background-color: #eee; }
  </style>
</head>
<body>

  <h2>Laporan Riwayat Saldo</h2>
  @if($tipe)
    <p><strong>Filter Tipe:</strong> {{ ucfirst($tipe) }}</p>
  @endif

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Waktu</th>
        <th>Tipe</th>
        <th>Jumlah</th>
        <th>Keterangan</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
        <td>{{ ucfirst($item->tipe) }}</td>
        <td>
          {{ $item->tipe == 'topup' ? '+Rp ' : '-Rp ' }}
          {{ number_format($item->jumlah, 0, ',', '.') }}
        </td>
        <td>{{ $item->keterangan ?? '-' }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

</body>
</html>
