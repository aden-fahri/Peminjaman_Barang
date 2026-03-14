@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0 pb-0 pt-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="mb-0 fw-bold text-dark">Kelola Pengguna</h4>
                    <p class="text-sm text-secondary mb-0 mt-1">Atur hak akses dan manajemen akun pengguna</p>
                </div>
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary px-3">
                    <i class="fas fa-arrow-left me-1"></i> Dashboard
                </a>
            </div>
        </div>

        <div class="card-body p-4">
            {{-- Alert Section --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light"> {{-- Gunakan class standar bootstrap --}}
                        <tr>
                            <th class="ps-3" style="width: 50px;">No</th>
                            <th>Profil Pengguna</th>
                            <th>Email</th>
                            <th>Role Saat Ini</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="ps-3 text-secondary">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                       
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold shadow-sm" 
                                             style="width: 40px; height: 40px; min-width: 40px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $user->name }}</div>
                                            <small class="text-muted d-md-none">{{ $user->email }}</small> 
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-secondary">{{ $user->email }}</span>
                                </td>
                                <td>
                                    @php
                                        $badgeClass = [
                                            'admin' => 'bg-danger',
                                            'staf' => 'bg-warning text-dark',
                                            'peminjam' => 'bg-info text-white'
                                        ][$user->role] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge rounded-pill {{ $badgeClass }} px-3">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-end gap-2 pe-2">
                                        {{-- Form Ubah Role --}}
                                        <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="m-0">
                                            @csrf 
                                            @method('PATCH')
                                            <select name="role" 
                                                    onchange="if(confirm('Ubah role {{ $user->name }}?')) this.form.submit()" 
                                                    class="form-select form-select-sm shadow-none" 
                                                    style="width: 130px;">
                                                <option value="peminjam" {{ $user->role === 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                                                <option value="staf" {{ $user->role === 'staf' ? 'selected' : '' }}>Staf</option>
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                        </form>

                                        {{-- Tombol Hapus --}}
                                        @if (Auth::id() !== $user->id)
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="m-0">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger border-0" 
                                                        onclick="return confirm('Hapus pengguna {{ addslashes($user->name) }}?')"
                                                        title="Hapus Pengguna">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-light text-muted border">Anda</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-users-slash fa-3x mb-3 opacity-25"></i>
                                        <p class="mb-0">Belum ada pengguna terdaftar</p>
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
@endsection