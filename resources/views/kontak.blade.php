<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home - PSAA Fajar Harapan </title>
    <!-- Tautan ke Bootstrap CSS dari CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Gaya kustom Anda -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <!-- Bagian Navbar -->
    <!-- Bagian Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container col-lg-12">
            <a class="navbar-brand" href="#">PSAA Fajar Harapan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav container col-lg-7">
                    <li class="nav-item mr-4{{ Request::is('/') ? 'active' : '' }}">
                        <a class="nav-link" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item dropdown mr-4">
                        <a class="nav-link dropdown-toggle" href="/profile" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Profile
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item " href="/visimisi">Visi & Misi</a></li>
                            <li><a class="dropdown-item" href="#">Struktur Pengurus</a></li>
                            <li><a class="dropdown-item" href="#">Legalitas Yayasan</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle mr-4" href="/informasi" id="navbarDropdownMenuLink2" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Informasi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Informasi Siswa</a></li>
                            <li><a class="dropdown-item" href="#">Informasi Pengurus</a></li>
                        </ul>
                    </li>
                    <li class="nav-item mr-4">
                        <a class="nav-link" href="/kegiatan">Kegiatan</a>
                    </li>
                    <li class="nav-item mr-4">
                        <a class="nav-link" href="/download">Download</a>
                    </li>
                    <li class="nav-item mr-4 {{ Request::is('kontak') ? 'active' : '' }}">
                        <a class="nav-link" href="/kontak">Kontak</a>
                    </li>
                </ul>
                <ul class="navbar-nav ">
                    <li class="nav-item ">
                        <a class="btn btn-light" href="/login" role="button">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>





    <!-- Bagian Header -->
    <header class="bg-secondary text-white text-center py-5">
        <div class="container">
            <h1 class="display-4">Selamat Datang di PSAA Fajar Harapan</h1>
            <p class="lead">Menciptakan Masa Depan Bersama</p>
        </div>
    </header>

    <!-- Bagian Kontak -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center">Hubungi Kami</h2>
            <p class="text-center">Jika Anda memiliki pertanyaan, silakan hubungi kami.</p>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form>
                        <div class="form-group">
                            <label for="nama">Nama:</label>
                            <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Anda">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" placeholder="Masukkan Email Anda">
                        </div>
                        <div class="form-group">
                            <label for="pesan">Pesan:</label>
                            <textarea class="form-control" id="pesan" rows="4" placeholder="Masukkan Pesan Anda"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>



    <!-- Bagian Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 - PSAA Fajar Harapan</p>
    </footer>


    <!-- Tautan ke Bootstrap JS dan Popper.js (jika diperlukan) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>