<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-white" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fa-solid fa-xmark p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="{{ url('/dashboard') }}">
      <img src="{{ asset('assets/img/logo-ct.png') }}" class="navbar-brand-img h-100" alt="main_logo">
      <span class="ms-1 font-weight-bold text-dark">Peminjaman Barang</span>
    </a>
  </div>
  
  <hr class="horizontal dark mt-0">

  <div class="navbar-collapse w-auto max-height-vh-100 h-100" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      
      {{-- Dashboard - untuk semua role --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ request()->routeIs('dashboard') ? 'bg-gradient-primary' : 'bg-white' }}">
            <i class="fa-solid fa-house {{ request()->routeIs('dashboard') ? 'text-white' : 'text-dark' }} text-xs"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>

      {{-- Kategori & Barang - HANYA untuk admin & staf --}}
      @if(in_array(Auth::user()->role, ['admin', 'staf']))
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ request()->routeIs('categories.*') ? 'bg-gradient-primary' : 'bg-white' }}">
              <i class="fa-solid fa-tags {{ request()->routeIs('categories.*') ? 'text-white' : 'text-dark' }} text-xs"></i>
            </div>
            <span class="nav-link-text ms-1">Kategori</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('items.*') ? 'active' : '' }}" href="{{ route('items.index') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ request()->routeIs('items.*') ? 'bg-gradient-primary' : 'bg-white' }}">
              <i class="fa-solid fa-boxes-stacked {{ request()->routeIs('items.*') ? 'text-white' : 'text-dark' }} text-xs"></i>
            </div>
            <span class="nav-link-text ms-1">Barang</span>
          </a>
        </li>
      @endif

      {{-- Peminjaman - untuk semua role --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('loans.*') ? 'active' : '' }}" href="{{ route('loans.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ request()->routeIs('loans.*') ? 'bg-gradient-primary' : 'bg-white' }}">
            <i class="fa-solid fa-hand-holding-heart {{ request()->routeIs('loans.*') ? 'text-white' : 'text-dark' }} text-xs"></i>
          </div>
          <span class="nav-link-text ms-1">Peminjaman</span>
        </a>
      </li>

      @if(Auth::user()->role === 'admin')
        <li class="nav-item mt-3">
          <hr class="horizontal dark">
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">pengaturan Pengguna</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center {{ request()->routeIs('admin.users.index') ? 'bg-gradient-primary' : 'bg-white' }}">
              <i class="fa-solid fa-users-gear {{ request()->routeIs('admin.users.index') ? 'text-white' : 'text-dark' }} text-xs"></i>
            </div>
            <span class="nav-link-text ms-1">Kelola Pengguna</span>
          </a>
        </li>
      @endif

    </ul>
  </div>
</aside>