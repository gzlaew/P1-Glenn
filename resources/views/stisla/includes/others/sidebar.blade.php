<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      @if (config('stisla.logo_aplikasi') != '')
        <a href="{{ url('') }}">
          <img style="max-width: 60%;" src="{{ asset(config('stisla.logo_aplikasi')) }}">
        </a>
      @else
        <a href="{{ url('') }}">{{ $_app_name }}</a>
      @endif
    </div>

    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ url('') }}">{{ $_app_name_mobile }}</a>
    </div>

    <ul class="sidebar-menu">
      <li class="menu-header">Menu</li>

      {{-- Pegawai (Hanya Admin) --}}
      @if (auth()->user()->role === 'Admin')
        <li class="nav-item @if (Request::is('pegawai*')) active @endif">
          <a class="nav-link" href="{{ route('pegawai.index') }}">
            <i class="fas fa-users"></i>
            <span>Pegawai</span>
          </a>
        </li>
      @endif

      {{-- Kategori / Penerbit / Pengarang (Admin & Petugas) --}}
      @if (in_array(auth()->user()->role, ['Admin', 'Petugas']))
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
         <li class="nav-item @if (Request::is('topup*')) active @endif">
          <a class="nav-link" href="{{ route('topup.index') }}">
            <i class="fas fa-tag"></i>
            <span>topup</span>
          </a>
        </li>
      @endif

      {{-- Setting Aplikasi (Hanya Admin) --}}
      @if (auth()->user()->role === 'Admin')
        <li class="nav-item @if (Request::is('setting')) active @endif">
          <a class="nav-link" href="{{ route('setting.index') }}">
            <i class="fas fa-cogs"></i>
            <span>Pengaturan</span>
          </a>
        </li>
      @endif
    </ul>
  </aside>
</div>
