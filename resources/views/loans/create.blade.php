@extends('layouts.app')

@section('title', 'Form Pengajuan Pinjam')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white pb-0">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm bg-gradient-primary shadow text-white me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border-radius: 8px;">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <h5 class="mb-0">Form Peminjaman Barang</h5>
                    </div>
                    <hr class="horizontal dark mt-3">
                </div>

                <div class="card-body pt-0">
                    {{-- Detail Barang Singkat --}}
                    <div class="bg-light p-3 border-radius-lg mb-4 d-flex align-items-center">
                        @if($item->gambar)
                            <img src="{{ Storage::url($item->gambar) }}" class="avatar avatar-lg me-3 border-radius-md" alt="item" style="object-fit: cover;">
                        @endif
                        <div>
                            <h6 class="mb-0 text-sm">{{ $item->nama }}</h6>
                            <p class="mb-0 text-xs text-secondary font-weight-bold">{{ $item->kode }}</p>
                            <span class="badge badge-sm bg-outline-primary text-primary border border-primary p-1" style="font-size: 10px">
                                Stok Tersedia: {{ $item->stok_tersedia }} Unit
                            </span>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                            <ul class="mb-0 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('loans.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-xs text-uppercase">Tanggal Kembali Rencana <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_kembali_rencana" 
                                       class="form-control @error('tanggal_kembali_rencana') is-invalid @enderror" 
                                       value="{{ old('tanggal_kembali_rencana') }}"
                                       min="{{ now()->format('Y-m-d') }}" required>
                                <small class="text-muted text-xxs">Kapan barang ini akan dikembalikan?</small>
                                @error('tanggal_kembali_rencana') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-xs text-uppercase">Nomor Telepon / WA <span class="text-danger">*</span></label>
                                <input type="tel" name="no_telepon" 
                                       class="form-control @error('no_telepon') is-invalid @enderror" 
                                       value="{{ old('no_telepon') }}" 
                                       placeholder="Contoh: 0812XXXXXXXX" required>
                                @error('no_telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold text-xs text-uppercase">Alamat Pengiriman (Opsional)</label>
                                <textarea name="alamat_peminjam" class="form-control" rows="2" 
                                          placeholder="Tuliskan alamat jika barang perlu dikirim...">{{ old('alamat_peminjam') }}</textarea>
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-xs text-uppercase">Catatan Tambahan</label>
                                <textarea name="catatan" class="form-control" rows="2" 
                                          placeholder="Contoh: Digunakan untuk keperluan rapat di aula...">{{ old('catatan') }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-link text-secondary mb-0">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn bg-gradient-primary px-5 shadow-sm mb-0">
                                Ajukan Peminjaman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection