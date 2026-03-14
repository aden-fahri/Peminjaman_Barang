<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        if ($role === 'peminjam') {
            $activeLoansCount = Loan::where('user_id', $user->id)
                ->where('status', 'dipinjam')->count();

            $pendingLoansCount = Loan::where('user_id', $user->id)
                ->where('status', 'pending')->count();

            $lateLoansCount = Loan::where('user_id', $user->id)
                ->where('status', 'dipinjam')
                ->where('tanggal_kembali_rencana', '<', now())
                ->count();

            $myActiveLoans = Loan::with('item')
                ->where('user_id', $user->id)
                ->whereIn('status', ['pending', 'dipinjam'])
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.peminjam', compact(
                'activeLoansCount', 'pendingLoansCount', 'lateLoansCount', 'myActiveLoans'
            ));
        }

        // Untuk staf & admin
        if (in_array($role, ['staf', 'admin'])) {
            $totalItems = Item::count();
            $borrowedItems = Item::sum(DB::raw('total_stok - stok_tersedia'));
            $pendingLoans = Loan::where('status', 'pending')->count();
            $lowStockItems = Item::where('stok_tersedia', '<=', 5)
                ->where('status', 'tersedia')
                ->count();

            $recentPendingLoans = Loan::with(['item', 'user'])
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.staf-admin', compact(
                'totalItems', 'borrowedItems', 'pendingLoans', 'lowStockItems', 'recentPendingLoans'
            ));
        }

        abort(403, 'Role tidak dikenali.');
    }
}