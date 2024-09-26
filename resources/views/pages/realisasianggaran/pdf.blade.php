<!-- pages/realisasianggaran/pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-size: 10px;
      font-family: Arial, Helvetica, sans-serif;
    }

    /* Correct the CSS comment syntax */
    table {
      border-collapse: collapse;
      width: 100%;
    }

    table,
    th,
    td {
      border: 1px solid black;
    }

    th,
    td {
      padding: 10px;
    }

    th {
      background-color: cadetblue;
      font-size: 12px;
    }

    h1 {
      text-align: center;
      color: red;
    }

    h2 {
      text-align: center;
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <h1>{{ $toko }}</h1>
  <h2>{{ $judul_laporan }}</h2>
  <table>
    <tr>
      <th>#</th>
      <th>Kode</th>
      <th>Bulan</th>
      <th>Tahun</th>
      <th>Deskripsi</th>
      <th>Anggaran</th>
      <th>Realisasi</th>
      <th>Selisih</th>
    </tr>
    @foreach($realisasi_anggarans as $realisasiAnggaran)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $realisasiAnggaran->kode }}</td>
      <td>{{ $realisasiAnggaran->bulan }}</td>
      <td>{{ $realisasiAnggaran->tahun }}</td>
      <td>{{ $realisasiAnggaran->deskripsi }}</td>
      <td>{{ $realisasiAnggaran->anggaran }}</td>
      <td>{{ $realisasiAnggaran->realisasi }}</td>
      <td>{{ $realisasiAnggaran->selisih }}</td>
    </tr>
    @endforeach
  </table>
</body>

</html>