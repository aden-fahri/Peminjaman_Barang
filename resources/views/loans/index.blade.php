@extends('layouts.app')

@section('title', 'Peminjaman Barang')

@section('content')
<div class="container-fluid py-4">
    {{-- Header Section --}}
    <div class="d-flex align-items-center mb-4">
        <div class="icon icon-shape icon-sm bg-gradient-primary shadow text-white border-radius-sm d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
            <i class="fa-solid fa-hand-holding-heart fa-lg"></i>
        </div>
        <div>
            <h4 class="mb-0 font-weight-bolder">Peminjaman Barang</h4>
            <p class="text-sm text-secondary mb-0">Kelola permintaan dan pantau inventaris Anda secara real-time.</p>
        </div>
    </div>

    {{-- Notifikasi khusus setelah di-approve --}}
    @if ($justApproved)
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show text-white mb-4" role="alert" style="background-image: linear-gradient(310deg, #2dce89 0%, #2dcecc 100%);">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check me-3 fa-2x"></i>
                <div>
                    <span class="alert-text"><strong>Peminjaman Disetujui!</strong> Silakan ambil <b>{{ $justApproved->item->nama }}</b>.</span>
                    <p class="text-xs mb-0">Batas pengembalian: {{ $justApproved->tanggal_kembali_rencana->format('d F Y') }}</p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Bagian 1: Barang Tersedia --}}
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-header bg-white pb-0">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-0 text-dark font-weight-bold">Barang Tersedia</h6>
                    <p class="text-xs text-secondary">Daftar item yang siap untuk Anda pinjam hari ini.</p>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table table-hover align-items-center mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sisa Stok</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div>
                                            @if ($item->gambar)
                                                <img src="{{ Storage::url($item->gambar) }}" class="avatar avatar-sm me-3 border-radius-lg" alt="item_img" style="object-fit: cover;">
                                            @else
                                                <div class="avatar avatar-sm me-3 bg-light border-radius-lg d-flex align-items-center justify-content-center">
                                                    <i class="fa-solid fa-box text-secondary text-xs"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $item->nama }}</h6>
                                            <p class="text-xs text-secondary mb-0 font-weight-bold">{{ $item->kode }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-xs font-weight-bold text-secondary">{{ $item->category->nama ?? '-' }}</span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm border border-info text-info">{{ $item->stok_tersedia }} Unit</span>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('loans.create', $item) }}" class="btn btn-link text-primary text-gradient px-3 mb-0 font-weight-bold">
                                        <i class="fa-solid fa-plus me-2"></i>Pinjam
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <p class="text-sm text-secondary mb-0">Tidak ada barang tersedia saat ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bagian 2: Riwayat Peminjaman Saya -->
    <h6 class="mt-5 mb-3 text-uppercase text-secondary fw-bold">Riwayat Peminjaman Saya</h6>
    <div class="table-responsive">
        <table class="table table-hover table-borderless align-middle">
            <thead class="bg-light">
                <tr>
                    <th>Barang</th>
                    <th>Tgl Pinjam</th>
                    <th>Tenggat Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($myLoans as $loan)
                    <tr class="border-bottom">
                        <td>
                            <div class="fw-bold">{{ $loan->item->nama }}</div>
                            <small class="text-muted">{{ $loan->item->kode }}</small>
                        </td>
                        <td>{{ $loan->tanggal_pinjam->format('d M Y') }}</td>
                        <td>
                            {{ $loan->tanggal_kembali_rencana->format('d M Y') }}
                            @if ($loan->status == 'dipinjam' && $loan->isLate())
                                <span class="badge bg-danger ms-2">Terlambat</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $badgeClass = match($loan->status) {
                                    'pending'      => 'bg-warning',
                                    'dipinjam'     => 'bg-info',
                                    'dikembalikan' => 'bg-success',
                                    'terlambat'    => 'bg-danger',
                                    'dibatalkan'   => 'bg-secondary',
                                    default        => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }} px-3 py-2">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </td>
                        <td>
                            @if ($loan->status == 'dipinjam')
                                <form action="{{ route('loans.return', $loan) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm bg-gradient-success" 
                                            onclick="return confirm('Yakin ingin mengembalikan {{ addslashes($loan->item->nama) }}?')">
                                        <i class="fa-solid fa-rotate-left me-1"></i> Kembalikan
                                    </button>
                                </form>
                            @elseif ($loan->status == 'dikembalikan')
                                <span class="text-success text-sm">Sudah Dikembalikan</span>
                            @else
                                <span class="text-muted text-sm">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-clock-rotate-left fa-3x mb-3 opacity-50 d-block"></i>
                            Belum ada riwayat peminjaman
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection