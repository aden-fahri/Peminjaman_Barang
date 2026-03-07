@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header pb-0 bg-white">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-shape icon-sm bg-gradient-warning shadow text-white me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border-radius: 8px;">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Edit Barang: {{ $item->nama }}</h5>
                            <p class="text-sm text-secondary mb-0">Perbarui informasi barang inventaris</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Alert Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                            <span class="alert-icon"><i class="fas fa-exclamation-triangle"></i></span>
                            <span class="alert-text"><strong>Ada kesalahan!</strong> Silakan periksa kembali form di bawah.</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-xs text-uppercase">Kode Barang <span class="text-danger">*</span></label>
                                <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" 
                                       value="{{ old('kode', $item->kode) }}" required placeholder="Contoh: BRG-001">
                                @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-xs text-uppercase">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                                       value="{{ old('nama', $item->nama) }}" required placeholder="Masukkan nama barang">
                                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-xs text-uppercase">Kategori</label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-xs text-uppercase">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    @foreach(['tersedia', 'dipinjam', 'rusak', 'hilang'] as $status)
                                        <option value="{{ $status }}" {{ old('status', $item->status) == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-xs text-uppercase">Total Stok <span class="text-danger">*</span></label>
                                <input type="number" name="total_stok" class="form-control @error('total_stok') is-invalid @enderror" 
                                       value="{{ old('total_stok', $item->total_stok) }}" min="1" required>
                                @error('total_stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-xs text-uppercase">Stok Tersedia <span class="text-danger">*</span></label>
                                <input type="number" name="stok_tersedia" class="form-control @error('stok_tersedia') is-invalid @enderror" 
                                       value="{{ old('stok_tersedia', $item->stok_tersedia) }}" min="0" required>
                                @error('stok_tersedia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold text-xs text-uppercase">Kondisi Barang</label>
                                <input type="text" name="kondisi" class="form-control @error('kondisi') is-invalid @enderror" 
                                       value="{{ old('kondisi', $item->kondisi) }}" placeholder="Contoh: Baik, Layak Pakai, Rusak Ringan">
                                @error('kondisi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-xs text-uppercase">Deskripsi</label>
                                {{-- Penulisan textarea dibuat rapat untuk menghindari whitespace --}}
                                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4" placeholder="Tambahkan keterangan detail barang...">{{ old('deskripsi', $item->deskripsi) }}</textarea>
                                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-xs text-uppercase">Gambar Barang</label>
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        @if($item->gambar)
                                            <img src="{{ Storage::url($item->gambar) }}" class="img-thumbnail rounded shadow-sm" alt="{{ $item->nama }}" style="width: 120px; height: 120px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="width: 120px; height: 120px;">
                                                <i class="fas fa-image text-secondary fa-2x"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <p class="text-xs text-secondary mb-2">Ganti gambar (Kosongkan jika tidak ingin mengubah):</p>
                                        <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                                        @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        <small class="text-muted mt-1">Format: JPG, PNG, WEBP (Max: 2MB)</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 border-top pt-4">
                            <a href="{{ route('items.index') }}" class="btn btn-link text-secondary me-3">Batal</a>
                            <button type="submit" class="btn bg-gradient-warning px-5 shadow-sm text-white">
                                <i class="fas fa-save me-2"></i> Update Barang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection