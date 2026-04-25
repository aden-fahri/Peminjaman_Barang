@extends('layouts.app')

@section('title', 'Persetujuan Peminjaman')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header pb-0 bg-white">
            <div class="d-flex align-items-center">
                <div class="icon icon-shape icon-sm bg-gradient-warning shadow text-white me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border-radius: 8px;">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div>
                    <h5 class="mb-0">Pengajuan Peminjaman Pending</h5>
                    <p class="text-sm text-secondary mb-0">Tinjau dan berikan keputusan untuk permintaan inventaris</p>
                </div>
            </div>
            <hr class="horizontal dark mt-3">
        </div>

        <div class="card-body pt-0">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                    <span class="text-sm">{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($pendingLoans->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fa-solid fa-circle-check fa-4x text-light"></i>
                    </div>
                    <h6 class="text-secondary opacity-7">Semua beres! Tidak ada antrean pengajuan saat ini.</h6>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Peminjam</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Barang</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Durasi Rencana</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kontak & Lokasi</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingLoans as $loan)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $loan->user->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $loan->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $loan->item->nama }}</p>
                                        <p class="text-xs text-secondary mb-0">SKU: {{ $loan->item->kode }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ $loan->tanggal_pinjam->format('d/m/Y') }} 
                                            <i class="fa-solid fa-arrow-right mx-1 text-xxs"></i> 
                                            {{ $loan->tanggal_kembali_rencana->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <p class="text-xs mb-0"><i class="fa-solid fa-phone text-xxs me-1"></i> {{ $loan->no_telepon }}</p>
                                        <p class="text-xs text-secondary mb-0"><i class="fa-solid fa-location-dot text-xxs me-1"></i> {{ Str::limit($loan->alamat_peminjam ?? 'Ambil di tempat', 30) }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- Approve Button --}}
                                            <form action="{{ route('loans.approve', $loan) }}" method="POST" 
                                                  onsubmit="return confirm('Setujui peminjaman {{ $loan->item->nama }} untuk {{ $loan->user->name }}?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm bg-gradient-success mb-0 py-1 px-3">
                                                    <i class="fa-solid fa-check me-1"></i> Setuju
                                                </button>
                                            </form>

                                            {{-- Reject Button --}}
                                            <form action="{{ route('loans.reject', $loan) }}" method="POST"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger mb-0 py-1 px-3">
                                                    <i class="fa-solid fa-xmark me-1"></i> Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                {{-- Baris opsional untuk catatan jika ada --}}
                                @if($loan->catatan)
                                <tr class="bg-light-soft">
                                    <td colspan="5" class="py-2">
                                        <div class="text-xs px-3">
                                            <strong class="text-primary text-uppercase">Catatan Peminjam:</strong> 
                                            <span class="fst-italic text-secondary">"{{ $loan->catatan }}"</span>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection