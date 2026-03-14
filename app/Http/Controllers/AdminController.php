<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function manageUsers()
    {
        $users = User::orderBy('name')->get();
        return view('admin.manage-users', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Jangan izinkan ubah role diri sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa mengubah role akun sendiri.');
        }

        $validated = $request->validate([
            'role' => 'required|in:peminjam,staf,admin',
        ]);

        $user->update(['role' => $validated['role']]);

        return back()->with('success', 'Role pengguna berhasil diubah menjadi ' . ucfirst($validated['role']) . '!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Jangan izinkan hapus diri sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
