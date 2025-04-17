<div class="main-sidebar">
  <aside id="sidebar-wrapper">

    <div class="sidebar-brand">
      @if (config('stisla.logo_aplikasi') != '')
        <a href="{{ url('') }}">
          <img style="max-width: 60%;" src="{{ asset(config('stisla.logo_aplikasi')) }}"></a>
      @else
        <a href="{{ url('') }}">{{ $_app_name }}</a>
      @endif
    </div>

    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ url('') }}">{{ $_app_name_mobile }}</a>
    </div>

    <ul class="sidebar-menu">
      <li class="menu-header">Menu</li>

      <li class="nav-item @if (Request::is('pegawai*')) active @endif">
        <a class="nav-link" href="{{ route('pegawai.index') }}">
          <i class="fas fa-users"></i>
          <span>Pegawai</span>
        </a>
      </li>

            <li class="nav-item @if (Request::is('kategori*')) active @endif">
        <a class="nav-link" href="{{ route('kategori.index') }}">
          <i class="fas fa-tag"></i>
          <span>Kategori</span>
        </a>
      </li>
        <li class="nav-item @if (Request::is('penerbit*')) active @endif">
        <a class="nav-link" href="{{ route('penerbit.index') }}">
          <i class="fas fa-tag"></i>
          <span>Penerbit</span>
        </a>
      </li>

              <li class="nav-item @if (Request::is('pengarang*')) active @endif">
        <a class="nav-link" href="{{ route('pengarang.index') }}">
          <i class="fas fa-tag"></i>
          <span>Pengarang</span>
        </a>
      </li>

      {{-- <li class="nav-item dropdown @if (Request::is('pegawai/pdf') || Request::is('pegawai/print') || Request::is('pegawai/excel') || Request::is('pegawai/csv') || Request::is('pegawai/json')) active @endif">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-file-export"></i>
          <span>Ekspor Pegawai</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{ route('pegawai.pdf') }}">Export PDF</a></li>
          <li><a class="nav-link" href="{{ route('pegawai.print') }}">Export Print</a></li>
          <li><a class="nav-link" href="{{ route('pegawai.excel') }}">Export Excel</a></li>
          <li><a class="nav-link" href="{{ route('pegawai.csv') }}">Export CSV</a></li>
          <li><a class="nav-link" href="{{ route('pegawai.json') }}">Export JSON</a></li>
        </ul>
      </li> --}}

      <li class="nav-item @if (Request::is('setting')) active @endif">
        <a class="nav-link" href="{{ route('setting.index') }}">
          <i class="fas fa-cogs"></i>
          <span>Pengaturan</span>
        </a>
      </li>
    </ul>
  </aside>
</div>
