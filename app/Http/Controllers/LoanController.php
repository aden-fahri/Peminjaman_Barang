<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::where('status', 'tersedia')
                ->where('stok_tersedia', '>', 0)
                ->with('category')
                ->latest()
                ->get();

        $myLoans = Loan::where('user_id', Auth::id())
                    ->with('Item')
                    ->latest()
                    ->get();

        $justApproved = session('just_approved_loan_id')
            ? Loan::with('item')->find(session('just_approved_loan_id')): null;

        session()->forget('just_approved_loan_id');

        // Pastikan nama variabel di sini 'items'
        return view('loans.index', compact('items', 'myLoans', 'justApproved'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Item $item)
    {
        if ($item->status !== 'tersedia' || $item->stok_tersedia < 1) {
        return redirect()->route('loans.index')
                         ->with('error', 'Barang ini tidak tersedia saat ini.');
    }

    return view('loans.create', compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id'                 => 'required|exists:items,id',
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:today',
            'catatan'                 => 'nullable|string|max:500',
            'alamat_peminjam'         => 'nullable|string|max:500',
            'no_telepon'              => 'nullable|string|max:20',
        ]);

        $item = Item::findOrFail($validated['item_id']);

        if ($item->status !== 'tersedia' || $item->stok_tersedia < 1) {
            return back()->withErrors(['item_id' => 'Barang sudah tidak tersedia.']);
        }

        Loan::create([
            'user_id'                 => Auth::id(),
            'item_id'                 => $validated['item_id'],
            'tanggal_pinjam'          => now(),
            'tanggal_kembali_rencana' => $validated['tanggal_kembali_rencana'],
            'status'                  => 'pending',
            'catatan'                 => $validated['catatan'] ?? null,
            'alamat_peminjam'         => $validated['alamat_peminjam'] ?? null,
            'no_telepon'              => $validated['no_telepon'] ?? null,
        ]);

        // Kurangi stok
        $item->decrement('stok_tersedia');
        if ($item->stok_tersedia <= 0) {
            $item->update(['status' => 'dipinjam']);
        }

        return redirect()->route('loans.index')
                         ->with('success', 'Pengajuan peminjaman berhasil! Silakan tunggu konfirmasi.');
    }

    public function pending(Loan $loan)
    {
        $pendingLoans = Loan::where('status', 'pending')
        ->with(['item', 'user'])           // optional: eager load relasi
        ->latest()
        ->get();

        return view('loans.pending', compact('pendingLoans'));
    }

    public function approve(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Peminjaman ini sudah diproses.');
        }

        $loan->update([
            'status' => 'dipinjam',
        ]);

        return redirect()->route('loans.pending')
                        ->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function reject(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Peminjaman ini sudah diproses.');
        }

        // Kembalikan stok kalau ditolak
        $loan->item->increment('stok_tersedia');
        if ($loan->item->stok_tersedia > 0 && $loan->item->status === 'dipinjam') {
            $loan->item->update(['status' => 'tersedia']);
        }

        $loan->update([
            'status' => 'dibatalkan',
        ]);

        return redirect()->route('loans.pending')
                        ->with('success', 'Peminjaman berhasil ditolak.');
    }

    public function return(Loan $loan)
    {
        // Cek apakah user login adalah pemilik pinjaman ATAU punya role admin/staf
        $user = Auth::user();

        if ($loan->user_id !== $user->id && !in_array($user->role, ['admin', 'staf'])) {
            abort(403);
        }

        if ($loan->status !== 'dipinjam') {
            return redirect()->route('loans.index')
                            ->with('error', 'Barang ini tidak sedang dipinjam atau sudah dikembalikan.');
        }

        $loan->update([
            'status'                 => 'dikembalikan',
            'tanggal_kembali_aktual' => now(),
        ]);

        $item = $loan->item;
        $item->increment('stok_tersedia');

        if ($item->stok_tersedia > 0 && $item->status === 'dipinjam') {
            $item->update(['status' => 'tersedia']);
        }

        return redirect()->route('loans.index')
                        ->with('success', 'Barang berhasil dikembalikan! Terima kasih.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
