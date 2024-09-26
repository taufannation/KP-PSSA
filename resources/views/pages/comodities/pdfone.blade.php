<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<style>
  body {
    font-size: 18px;
    font-family: Arial, Helvetica, sans-serif;
  }

  th,
  td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
  }

  th {
    background-color: #f2f2f2;
  }

  .page-break {
    page-break-after: always;
  }
</style>

<body>
  <table border="1" cellpadding="0" cellspacing="0" style="width: 100%;">
    <tr>
      <td colspan="2" style="background-color: #333; color: #fff; text-align: center; padding: 15px;">
        <strong>Data Asset {{$toko}}</strong>
      </td>
    </tr>
    <tr>
      <th>Nama Barang</th>
      <td>{{ $comodities->name }}</td>
    </tr>
    <tr>
      <th>Kode Barang</th>
      <td>{{ $comodities->item_code }}</td>
    </tr>
    <tr>
      <th>Tanggal Peroleh</th>
      <td>{{ $comodities->date_of_purchase }}</td>
    </tr>
    <tr>
      <th>Merek</th>
      <td>{{ $comodities->brand }}</td>
    </tr>
    <tr>
      <th>Bahan</th>
      <td>{{ $comodities->material }}</td>
    </tr>
    <tr>
      <th>Kondisi</th>
      <td>
        @if($comodities->condition == 1)
        Baik
        @elseif($comodities->condition == 2)
        Kurang Baik
        @elseif($comodities->condition == 3)
        Rusak Ringan
        @else
        Unknown
        @endif
      </td>
    </tr>
    <tr>
      <th>Kuantitas</th>
      <td>{{ $comodities->quantity }}</td>
    </tr>
    <tr>
      <th>Harga</th>
      <td>{{ $comodities->price }}</td>
    </tr>
    <tr>
      <th>Lokasi</th>
      <td>{{ $comodities->comodity_locations->name }}</td>
    </tr>
    <tr>
      <th>Keterangan</th>
      <td>{{ $comodities->note }}</td>
    </tr>
  </table>
</body>

</html>