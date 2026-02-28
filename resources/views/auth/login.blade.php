@extends('layouts.guest')  <!-- atau langsung full html kalau belum punya layout -->

@section('content')
<main class="main-content mt-0">
  <section>
    <div class="page-header min-vh-75">
      <div class="container">
        <div class="row">
          <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
            <div class="card card-plain mt-8">
              <div class="card-header pb-0 text-left bg-transparent">
                <h3 class="font-weight-bolder text-info text-gradient">Welcome back</h3>
                <p class="mb-0">Masukkan email dan password untuk masuk ke sistem peminjaman barang</p>
              </div>

              <div class="card-body">

                <!-- Tampilkan pesan sukses / error -->
                @if (session('success'))
                  <div class="alert alert-success text-white">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                  <div class="alert alert-danger text-white">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}" role="form">
                  @csrf

                  <label class="form-label">Email</label>
                  <div class="mb-3">
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email" 
                           placeholder="Email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus>
                    @error('email')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <label class="form-label">Password</label>
                  <div class="mb-3">
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" 
                           placeholder="Password" 
                           required>
                    @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                    <label class="form-check-label" for="rememberMe">Ingat saya</label>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Masuk</button>
                  </div>
                </form>
              </div>

              <div class="card-footer text-center pt-0 px-lg-2 px-1">
                <p class="mb-4 text-sm mx-auto">
                  Belum punya akun? 
                  <a href="{{ route('register') }}" class="text-info text-gradient font-weight-bold">Daftar</a>
                </p>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
              <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" 
                   style="background-image: url('{{ asset('assets/img/curved-images/curved6.jpg') }}')"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection