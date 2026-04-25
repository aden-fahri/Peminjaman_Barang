@extends('layouts.app')

@section('title', 'Dashboard ' . ucfirst(Auth::user()->role))

@section('content')

    <div class="row align-items-center mb-3"> 
        <div class="col-md-7 text-center text-md-start">
            <h3 class="font-weight-bolder mb-1 text-gradient text-primary">
                Selamat Datang, {{ Auth::user()->name }}
            </h3>
            <p class="text-sm text-secondary mb-0">
                Role: <span class="badge bg-light text-dark">{{ ucfirst(Auth::user()->role) }}</span> • 
                Pantau inventaris secara real-time
            </p>
        </div>
        <div class="col-md-5 text-center text-md-end mt-3 mt-md-0">
            <a href="{{ route('items.create') }}" class="btn bg-gradient-primary btn-sm me-2 shadow-sm mb-0">
                <i class="fa-solid fa-plus me-1"></i> Tambah Barang
            </a>
            <a href="{{ route('loans.pending') }}" class="btn btn-outline-primary btn-sm position-relative shadow-sm mb-0">
                <i class="fa-solid fa-clock me-1"></i> Pending
                @if($pendingLoans > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white" style="font-size: 0.65rem;">
                        {{ $pendingLoans }}
                    </span>
                @endif
            </a>
        </div>
    </div>

    <div class="row">
        @php
            $stats = [
                ['label' => 'Total Barang', 'value' => $totalItems, 'icon' => 'fa-box', 'color' => 'text-primary'],
                ['label' => 'Sedang Dipinjam', 'value' => $borrowedItems, 'icon' => 'fa-hand-holding', 'color' => 'text-info'],
                ['label' => 'Pending Approval', 'value' => $pendingLoans, 'icon' => 'fa-user-clock', 'color' => 'text-warning'],
                ['label' => 'Stok Rendah', 'value' => $lowStockItems, 'icon' => 'fa-triangle-exclamation', 'color' => 'text-danger'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="col-xl-3 col-sm-6 mb-3"> 
            <div class="card shadow-sm border-radius-xl border-0">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center"> 
                        <div class="numbers flex-grow-1">
                            <p class="text-xs text-uppercase font-weight-bold mb-0 opacity-7">{{ $stat['label'] }}</p>
                            <h5 class="font-weight-bolder mb-0 {{ $stat['color'] }}">
                                {{ number_format($stat['value']) }}
                            </h5>
                        </div>
                        <div class="ms-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary border-radius-lg d-flex align-items-center justify-content-center w-100 h-100">
                                <i class="fa-solid {{ $stat['icon'] }} text-white text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row mt-2"> 
        <div class="col-12">
            <div class="card shadow border-radius-xl border-0">
                <div class="card-header pb-2 d-flex justify-content-between align-items-center bg-transparent border-0 px-4 pt-4">
                    <h6 class="mb-0 font-weight-bolder text-dark">Permintaan Pending Terbaru</h6>
                    <a href="{{ route('loans.pending') }}" class="btn btn-link text-primary text-xs px-0 mb-0">
                        Lihat Semua <i class="fa-solid fa-chevron-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body px-0 pb-2 pt-0"> 
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr class="bg-light shadow-none">
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Peminjam</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Barang</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Waktu Pengajuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentPendingLoans as $loan)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex py-1 align-items-center">
                                                <div class="icon icon-shape bg-gradient-primary shadow-primary border-radius-sm d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                                    <i class="fa-solid fa-user text-white text-xxs"></i>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm font-weight-bold text-dark">{{ $loan->user->name ?? 'Pengguna' }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $loan->user->email ?? '-' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm mb-0 font-weight-bold">{{ Str::limit($loan->item->nama, 35) }}</h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa-solid fa-barcode me-1"></i> {{ $loan->item->kode }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-column justify-content-center">
                                                <span class="text-sm font-weight-bold text-dark">{{ $loan->created_at->format('d M Y') }}</span>
                                                <span class="text-xs text-secondary">
                                                    <i class="fa-regular fa-clock me-1"></i>{{ $loan->created_at->format('H:i') }} WIB
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <div class="py-3">
                                                <i class="fa-solid fa-inbox fa-3x mb-3 d-block opacity-2"></i>
                                                <p class="mb-0 text-sm font-weight-bold text-secondary">Belum ada permintaan pending</p>
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