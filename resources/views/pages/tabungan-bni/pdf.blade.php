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

      background-color: #3abaf4;
      font-size: 12px;

    }

    h2 {
      text-align: center;
      color: black;
    }

    h1 {
      text-align: center;
      color: red;
    }
  </style>
</head>

<body>
  <h1>Lembaga Kesejahteraan Sosial Anak Fajar Harapan</h1>
  <h2>{{ $judul_report }}</h2>

  <table>
    <tr>
      <th>#</th>
      <th>Tanggal Transaksi</th>
      <th>Kode</th>
      <th>Keterangan</th>
      <th>Debet</th>
      <th>Kredit</th>
      <th>Sisa Saldo</th>

    </tr>
    @foreach($kode_bnis as $kodebni)
    <tr>
      <td align="center" width="20">{{ $loop->iteration }}</td>
      <td align="center" width="50">{{ date('d-m-Y', strtotime($kodebni->tanggal_transaksi)) }}</td>
      <td align="center" width="50">{{ (isset($kodebni->kode_bni->kode) ? $kodebni->kode_bni->kode : '') }}</td>
      <td>{{ $kodebni->nama_transaksi }}</td>
      <td align="right" width="50">{{ number_format($kodebni->debet, 0, ',', '.') }}</td>
      <td align="right" width="50">{{ number_format($kodebni->kredit, 0, ',', '.')}}</td>
      <td align="right" width="50">{{ number_format($kodebni->saldo, 0, ',', '.') }}</td>
    </tr>
    @endforeach
  </table>
</body>

</html>