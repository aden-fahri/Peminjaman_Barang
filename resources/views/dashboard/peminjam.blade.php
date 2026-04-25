@extends('layouts.app')

@section('title', 'Dashboard Peminjam')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0">Selamat Datang, {{ Auth::user()->name }}</h6>
                    <p class="text-sm text-secondary mb-0">Overview peminjaman kamu hari ini</p>
                </div>
                <a href="{{ route('loans.index') }}" class="btn bg-gradient-primary btn-sm">
                    <i class="fa-solid fa-plus me-2"></i> Pinjam Barang Baru
                </a>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card border shadow-xs mb-4">
                            <div class="card-body text-start p-3 w-100">
                                <div class="icon icon-shape icon-sm bg-gradient-primary shadow text-white mb-3">
                                    <i class="fa-solid fa-rotate text-lg opacity-10"></i>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="text-sm font-weight-bold text-uppercase mb-1">Aktif Dipinjam</div>
                                        <div class="h5 font-weight-bolder mb-0">{{ $activeLoansCount }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card border shadow-xs mb-4">
                            <div class="card-body text-start p-3 w-100">
                                <div class="icon icon-shape icon-sm bg-gradient-warning shadow text-white mb-3">
                                    <i class="fa-solid fa-clock text-lg opacity-10"></i>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="text-sm font-weight-bold text-uppercase mb-1">Menunggu Approval</div>
                                        <div class="h5 font-weight-bolder mb-0">{{ $pendingLoansCount }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6">
                        <div class="card border shadow-xs mb-4">
                            <div class="card-body text-start p-3 w-100">
                                <div class="icon icon-shape icon-sm bg-gradient-danger shadow text-white mb-3">
                                    <i class="fa-solid fa-triangle-exclamation text-lg opacity-10"></i>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="text-sm font-weight-bold text-uppercase mb-1">Terlambat</div>
                                        <div class="h5 font-weight-bolder mb-0 text-danger">{{ $lateLoansCount }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Peminjaman Saya -->
                <div class="card mt-4">
                    <div class="card-header pb-0">
                        <h6>Peminjaman Terbaru Saya</h6>
                    </div>
                    <div class="card-body px-0 pt-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Barang</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tgl Pinjam</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tenggat</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($myActiveLoans as $loan)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $loan->item->nama }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $loan->item->kode }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-sm">{{ $loan->tanggal_pinjam->format('d M Y') }}</td>
                                            <td class="text-sm">{{ $loan->tanggal_kembali_rencana->format('d M Y') }}</td>
                                            <td>
                                                <span class="badge badge-sm {{ $loan->status == 'dipinjam' ? 'bg-gradient-info' : 'bg-gradient-warning' }}">
                                                    {{ ucfirst($loan->status) }}
                                                </span>
                                                @if($loan->tanggal_kembali_rencana < now() && $loan->status == 'dipinjam')
                                                    <span class="badge badge-sm bg-gradient-danger ms-2">Terlambat</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center py-4 text-secondary">Belum ada peminjaman aktif</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection