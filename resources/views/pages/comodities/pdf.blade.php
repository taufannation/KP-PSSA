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
      padding: 8px;
      text-align: center;

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
  <h2>DATA ASSET</h2>

  <table>
    <tr>
      <th>No</th>
      <th>Kode</th>
      <th>Nama Barang</th>
      <th>Merek</th>
      <th>Bahan</th>
      <th>Tgl Peroleh</th>
      <th>Kondisi</th>
      <th>Jml</th>
      <th>Harga</th>
      <th>Lokasi</th>
      <th>Ket</th>
    </tr>
    @foreach($comodities as $commodity)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $commodity->item_code }}</td>
      <td>{{ $commodity->name }}</td>
      <td>{{ $commodity->brand }}</td>
      <td>{{ $commodity->material }}</td>
      <td>{{ $commodity->date_of_purchase }}</td>
      <td>
        @if ($commodity->condition === 1)
        <span class="badge badge-pill badge-info" data-toggle="tooltip" data-placement="top" title="Baik">Baru</span>
        @elseif ($commodity->condition === 2)
        <span class="badge badge-pill badge-warning" data-toggle="tooltip" data-placement="top" title="Kurang Baik">Baik</span>
        @elseif ($commodity->condition === 3)
        <span class="badge badge-pill badge-warning" data-toggle="tooltip" data-placement="top" title="Kurang Baik">Rusak</span>
        @else
        <span class="badge badge-pill badge-danger" data-toggle="tooltip" data-placement="top" title="Rusak">Hilang</span>
        @endif
      </td>
      <td>{{ $commodity->quantity }}</td>
      <td>{{ $commodity->price }}</td>
      <td>{{ $commodity->comodity_locations->name }}</td>
      <td>{{ $commodity->note }}</td>
    </tr>
    @endforeach
  </table>
</body>

</html>