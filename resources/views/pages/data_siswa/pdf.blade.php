<!-- pages/kaskecil/pdf.blade.php -->
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
  <h2>Data Siswa</h2>

  <table>
    <tr>
      <th>No</th>
      <th>Foto</th>
      <th>Nama</th>
      <th>TTL</th>
      <th>JK</th>
      <th>Pend. Terakhir</th>
      <th>Nama Ayah</th>
      <th>Nama Ibu</th>
      <th>Pekerjaan Ortu</th>
      <th>Alamat</th>
      <th>Tanggal Masuk</th>
      <th>Tanggal Keluar</th>
      <th>Status</th>
      <th>Keterangan</th>


    </tr>
    @foreach($data_siswas as $datasiswa)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>
        @if ($datasiswa->foto)
        <img src="{{ public_path('fotosiswa') . '/' . $datasiswa->foto }}" alt="Foto" style="width: 50px; height: 50px;">
        @else
        Tidak ada foto
        @endif
      </td>
      <td>{{ $datasiswa->nama }}</td>
      <td>{{ $datasiswa->tanggal_lahir }}</td>
      <td style="text-align: center;">{{ $datasiswa->jenis_kelamin }}</td>
      <td>{{ $datasiswa->pendidikan_terakhir }}</td>
      <td>{{ $datasiswa->nama_ayah }}</td>
      <td>{{ $datasiswa->nama_ibu }}</td>
      <td>{{ $datasiswa->pekerjaan_orangtua }}</td>
      <td>{{ $datasiswa->alamat }}</td>
      <td>{{ $datasiswa->tanggal_masuk }}</td>
      <td>{{ $datasiswa->tanggal_keluar }}</td>
      <td>{{ $datasiswa->status }}</td>
      <td>{{ $datasiswa->keterangan }}</td>
    </tr>
    @endforeach
  </table>
</body>

</html>