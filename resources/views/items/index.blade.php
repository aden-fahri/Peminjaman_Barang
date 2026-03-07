@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 shadow-sm">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center bg-white">
                <div>
                    <h6 class="mb-0">Daftar Barang / Inventaris</h6>
                    <p class="text-xs text-secondary mb-0">Kelola aset dan stok barang inventaris Anda</p>
                </div>
                <a href="{{ route('items.create') }}" class="btn bg-gradient-primary btn-sm mb-0">
                    <i class="fas fa-plus me-2"></i> Tambah Barang
                </a>
            </div>

            <div class="card-body px-0 pt-0 pb-2">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-3 mt-3 text-white border-0" role="alert">
                        <span class="alert-icon"><i class="fas fa-check-circle me-2"></i></span>
                        <span class="alert-text"><strong>Berhasil!</strong> {{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
                        <strong>Ada kesalahan:</strong>
                        <ul class="mb-0 ms-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Kode & Nama</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kategori</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Stok</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-secondary opacity-7 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex px-0 py-1">
                                        <div>
                                            @if ($item->gambar)
                                                <img src="{{ Storage::url($item->gambar) }}" class="avatar avatar-sm me-3 border-radius-lg border shadow-sm" alt="{{ $item->nama }}" style="object-fit: cover; width: 40px; height: 40px;">
                                            @else
                                                <div class="avatar avatar-sm me-3 border-radius-lg bg-gradient-light border d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-box text-secondary text-xxs"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $item->nama }}</h6>
                                            <p class="text-xs text-primary mb-0 font-weight-bold">{{ $item->kode }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $item->category->nama ?? 'Tanpa Kategori' }}</p>
                                </td>
                                <td class="text-center">
                                    <span class="text-sm font-weight-bold">
                                        {{ $item->stok_tersedia }} / {{ $item->total_stok }}
                                        <small class="text-secondary">unit</small>
                                    </span>
                                    @if ($item->stok_tersedia <= 2 && $item->status === 'tersedia')
                                        <span class="badge badge-sm bg-danger ms-2">Stok rendah</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match($item->status) {
                                            'tersedia' => 'bg-gradient-success',
                                            'dipinjam' => 'bg-gradient-warning',
                                            'rusak'    => 'bg-gradient-danger',
                                            'hilang'   => 'bg-gradient-dark',
                                            default    => 'bg-gradient-secondary',
                                        };
                                    @endphp
                                    <span class="badge badge-sm {{ $badgeClass }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group shadow-none">
                                        <button type="button" class="btn btn-link text-info p-2 mb-0" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#detailModal{{ $item->id }}" 
                                                title="Detail">
                                            <i class="fas fa-eye text-lg"></i>
                                        </button>
                                        <a href="{{ route('items.edit', $item) }}" 
                                           class="btn btn-link text-warning p-2 mb-0" 
                                           title="Edit">
                                            <i class="fas fa-edit text-lg"></i>
                                        </a>
                                        <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-2 mb-0" 
                                                    onclick="return confirm('Yakin hapus {{ addslashes($item->nama) }}?')" 
                                                    title="Hapus">
                                                <i class="fas fa-trash text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Detail -->
                            <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-lg">
                                        <div class="modal-body p-0">
                                            <div class="card card-plain shadow-none mb-0">
                                                <div class="card-header pb-0 text-left position-relative">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h5 class="font-weight-bolder text-primary text-gradient">Detail Barang</h5>
                                                            <p class="mb-0 text-sm">Informasi lengkap inventaris</p>
                                                        </div>
                                                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"></button>
                                                    </div>
                                                </div>
                                                <div class="card-body p-4">
                                                    <div class="row">
                                                        <div class="col-lg-5 col-md-12">
                                                            <div class="position-relative border-radius-lg overflow-hidden shadow-sm mb-3" style="background: #f8f9fa;">
                                                                @if($item->gambar)
                                                                    <img src="{{ Storage::url($item->gambar) }}" class="w-100 border-radius-lg shadow-lg" alt="{{ $item->nama }}" style="object-fit: cover; min-height: 280px; max-height: 280px;">
                                                                @else
                                                                    <div class="d-flex align-items-center justify-content-center" style="min-height: 280px;">
                                                                        <i class="fas fa-box fa-5x text-secondary opacity-2"></i>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="d-flex gap-2 mb-3">
                                                                <div class="flex-fill text-center p-2 bg-light border-radius-md">
                                                                    <p class="text-xxs text-uppercase font-weight-bolder text-secondary mb-0">Stok Tersedia</p>
                                                                    <h6 class="font-weight-bolder mb-0">{{ $item->stok_tersedia }}</h6>
                                                                </div>
                                                                <div class="flex-fill text-center p-2 bg-light border-radius-md">
                                                                    <p class="text-xxs text-uppercase font-weight-bolder text-secondary mb-0">Total Stok</p>
                                                                    <h6 class="font-weight-bolder mb-0">{{ $item->total_stok }}</h6>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-7 col-md-12">
                                                            <ul class="list-group">
                                                                <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                                                    <strong>Nama Barang:</strong> {{ $item->nama }}
                                                                </li>
                                                                <li class="list-group-item border-0 ps-0 text-sm">
                                                                    <strong>Kode:</strong> 
                                                                    <span class="badge bg-light text-primary border border-primary">{{ $item->kode }}</span>
                                                                </li>
                                                                <li class="list-group-item border-0 ps-0 text-sm">
                                                                    <strong>Kategori:</strong> {{ $item->category->nama ?? 'Tanpa Kategori' }}
                                                                </li>
                                                                <li class="list-group-item border-0 ps-0 text-sm">
                                                                    <strong>Kondisi:</strong> {{ $item->kondisi ?? '-' }}
                                                                </li>
                                                                <hr class="horizontal dark my-2">
                                                                <li class="list-group-item border-0 ps-0 text-sm">
                                                                    <strong>Deskripsi:</strong><br>
                                                                    <p class="text-secondary mt-1" style="line-height: 1.5; font-size: 0.85rem;">
                                                                        {{ $item->deskripsi ?: 'Tidak ada deskripsi tambahan.' }}
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-gray-100 border-radius-lg p-3 d-flex justify-content-end">
                                                    <button type="button" class="btn btn-link text-dark mb-0" data-bs-dismiss="modal">Tutup</button>
                                                    <a href="{{ route('items.edit', $item) }}" class="btn bg-gradient-dark mb-0">
                                                        <i class="fas fa-edit me-2"></i> Edit Data
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="opacity-3">
                                        <i class="fas fa-box-open fa-4x mb-3"></i>
                                        <h6 class="text-secondary">Data barang masih kosong</h6>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection