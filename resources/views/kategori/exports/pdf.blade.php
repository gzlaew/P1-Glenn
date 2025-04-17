<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Export PDF - Data Kategori</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 14px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #000;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    h2 {
      text-align: center;
    }
  </style>
</head>
<body>
  <h2>Data Kategori</h2>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Kategori</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($kategoriList as $index => $kategori)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $kategori->nama_kategori }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
