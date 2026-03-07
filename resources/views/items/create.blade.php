@extends('layouts.app')

@section('title', 'Tambah Barang Baru')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header pb-0 bg-white">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm bg-gradient-primary shadow text-white me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border-radius: 8px;">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Tambah Barang Baru</h5>
                            <p class="text-sm text-secondary mb-0">Isi informasi barang inventaris dengan lengkap</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Alert Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                            <span class="alert-icon"><i class="fas fa-exclamation-circle"></i></span>
                            <span class="alert-text ms-1"><strong>Mohon maaf,</strong> ada beberapa kesalahan input. silakan cek daftar di bawah.</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-xs text-uppercase">Kode Barang <span class="text-danger">*</span></label>
                                <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" 
                                       value="{{ old('kode') }}" placeholder="Contoh: BRG-001" required autofocus>
                                @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-xs text-uppercase">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                                       value="{{ old('nama') }}" placeholder="Contoh: Meja Kantor" required>
                                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-xs text-uppercase">Kategori</label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-xs text-uppercase">Status Awal <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                    <option value="rusak" {{ old('status') == 'rusak' ? 'selected' : '' }}>Rusak (Stok Mati)</option>
                                    <option value="hilang" {{ old('status') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-xs text-uppercase">Total Stok <span class="text-danger">*</span></label>
                                <input type="number" name="total_stok" class="form-control @error('total_stok') is-invalid @enderror" 
                                       value="{{ old('total_stok', 1) }}" min="1" required>
                                @error('total_stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-xs text-uppercase">Stok Tersedia (Fisik Baik) <span class="text-danger">*</span></label>
                                <input type="number" name="stok_tersedia" class="form-control @error('stok_tersedia') is-invalid @enderror" 
                                       value="{{ old('stok_tersedia', 1) }}" min="0" required>
                                @error('stok_tersedia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold text-xs text-uppercase">Kondisi Barang</label>
                                <input type="text" name="kondisi" class="form-control @error('kondisi') is-invalid @enderror" 
                                       value="{{ old('kondisi') }}" placeholder="Contoh: Baru, Box Tersegel, Baik">
                                @error('kondisi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-xs text-uppercase">Deskripsi / Spesifikasi</label>
                                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4" 
                                          placeholder="Contoh: Warna Hitam, Ukuran 120x60cm, Merk IKEA">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-xs text-uppercase">Foto Barang</label>
                                <div class="border-dashed border-secondary rounded-3 p-3 text-center bg-light">
                                    <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                                    <div class="mt-2">
                                        <small class="text-muted">Format: JPG, PNG, WEBP. Maksimal ukuran file 2MB.</small>
                                    </div>
                                    @error('gambar') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 border-top pt-4">
                            <a href="{{ route('items.index') }}" class="btn btn-link text-secondary me-3">Batal</a>
                            <button type="submit" class="btn bg-gradient-primary px-5 shadow-sm">
                                <i class="fas fa-save me-2"></i> Simpan Inventaris
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection