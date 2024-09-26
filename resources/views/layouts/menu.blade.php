<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="#">PSAA FAJAR HARAPAN</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="#">PSAA</a>
  </div>

  <ul class="sidebar-menu">
    <li class="menu-header">Dashboard</li>
    <li class="nav-item {{ Request::is('/*') ? 'active' : '' }}">
      <a href="{{ asset('/') }}" class="nav-link"><i class="fa fa-home" aria-hidden="true"></i><span>Dashboard</span></a>
    </li>

    <li class="menu-header">Management</li>
    <li class="nav-item {{ Request::is('comodities*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ asset('comodities') }}"><i class="fa fa-building"></i> <span>Data Asset</span></a>
    </li>

    <li class="nav-item dropdown {{ Request::is(['tabungan*', 'kaskecil*', 'realisasianggaran*']) ? 'show active' : '' }}" data-dropdown-category="data_keuangan">
      <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fa fa-credit-card"></i> <span>Data Keuangan</span>
      </a>
      <ul class="dropdown-menu" data-dropdown-category="data_keuangan">
        <li class="{{ Request::is('kaskecil*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ asset('kaskecil') }}">Kas Kecil</a>
        </li>
        <li class="{{ Request::is('tabungan*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ asset('tabungan') }}">Tabungan</a>
        </li>
        <li class="{{ Request::is('realisasianggaran*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ asset('realisasianggaran') }}">Realisasi Anggaran</a>
        </li>
      </ul>
    </li>

    <li class="nav-item {{ Request::is('data_siswa*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ asset('data_siswa') }}"><i class="fa fa-graduation-cap"></i> <span>Data Siswa</span></a>
    </li>

    <li class="nav-item {{ Request::is('data_pengajar*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ asset('data_pengajar') }}"><i class="fa fa-users"></i> <span>Data Pengelolah</span></a>
    </li>
  </ul>

  <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
    <a href="{{ route('logout') }}" class="btn btn-primary btn-lg btn-block btn-icon-split" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
    <form action="{{ route('logout') }}" method="POST" id="logout-form">
      @csrf
    </form>
  </div>
</aside>