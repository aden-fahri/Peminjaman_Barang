@extends('layouts.guest')

@section('content')
<main class="main-content mt-0">
  <section class="min-vh-100 mb-8">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" 
         style="background-image: url('{{ asset('assets/img/curved-images/curved14.jpg') }}');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Selamat Datang!</h1>
            <p class="text-lead text-white">Daftar sekarang untuk mulai meminjam barang di sistem kami.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">

            <!-- Optional: social buttons, bisa dihapus kalau tidak dipakai -->
            <div class="card-header text-center pt-4">
              <h5>Daftar dengan</h5>
            </div>
            <!-- ... bagian social buttons bisa dihapus atau dibiarkan sebagai placeholder ... -->

            <div class="card-body">
              <!-- Pesan error umum / sukses -->
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <form method="POST" action="{{ route('register') }}" role="form text-left">
                @csrf

                <div class="mb-3">
                  <input type="text" 
                         class="form-control @error('name') is-invalid @enderror" 
                         name="name" 
                         placeholder="Nama Lengkap" 
                         value="{{ old('name') }}" 
                         required>
                  @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="mb-3">
                  <input type="email" 
                         class="form-control @error('email') is-invalid @enderror" 
                         name="email" 
                         placeholder="Email" 
                         value="{{ old('email') }}" 
                         required>
                  @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="mb-3">
                  <input type="password" 
                         class="form-control @error('password') is-invalid @enderror" 
                         name="password" 
                         placeholder="Password" 
                         required>
                  @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="mb-3">
                  <input type="password" 
                         class="form-control" 
                         name="password_confirmation" 
                         placeholder="Konfirmasi Password" 
                         required>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Daftar</button>
                </div>

                <p class="text-sm mt-3 mb-0">
                  Sudah punya akun? 
                  <a href="{{ route('login') }}" class="text-dark font-weight-bolder">Masuk</a>
                </p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer sama seperti aslinya -->
  <footer class="footer py-5">
    <div class="container">
      <div class="row">
        <div class="col-8 mx-auto text-center mt-1">
          <p class="mb-0 text-secondary">
            Copyright © <script>document.write(new Date().getFullYear())</script> Sistem Peminjaman Barang
          </p>
        </div>
      </div>
    </div>
  </footer>
</main>
@endsection