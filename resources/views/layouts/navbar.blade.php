<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a href="{{ route('dashboard') }}" class="opacity-8 text-dark">Dashboard</a>
                </li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                    @yield('title')
                </li>
            </ol>
            <h6 class="font-weight-bolder mb-0">@yield('title')</h6>
        </nav>

        <div class="collapse navbar-collapse mt-sm-0 mt-2" id="navbar">
            <ul class="navbar-nav justify-content-end ms-auto">
                <li class="nav-item d-flex align-items-center">
                    <!-- User Info -->
                    <div class="d-flex align-items-center me-3">
                        <i class="fa fa-user-circle fa-lg me-2 text-secondary"></i>
                        <span class="d-sm-inline d-none fw-bold text-dark">
                            {{ Auth::user()?->name ?? 'Pengguna' }}
                        </span>
                    </div>

                    <!-- Logout -->
                    <a href="{{ route('logout') }}"
                       class="nav-link text-danger fw-bold px-0 d-flex align-items-center"
                       onclick="event.preventDefault(); 
                               if(confirm('Yakin ingin logout?')) {
                                   document.getElementById('logout-form').submit();
                               }">
                        <i class="fa fa-sign-out-alt me-1"></i>
                        <span class="d-sm-inline d-none">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>