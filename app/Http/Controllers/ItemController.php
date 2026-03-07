<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = item::with('category')->latest()->get();
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('nama')->get();
        return view('items.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode'            => 'required|string|max:50|unique:items,kode',
            'nama'            => 'required|string|max:150',
            'deskripsi'       => 'nullable|string',
            'gambar'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
            'stok_tersedia'   => 'required|integer|min:0',
            'total_stok'      => 'required|integer|min:1',
            'category_id'     => 'nullable|exists:categories,id',
            'status'          => 'required|in:tersedia,dipinjam,rusak,hilang',
            'kondisi'         => 'nullable|string|max:100',
        ]);

        // Handle upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('items', 'public');
            $validated['gambar'] = $path;
        }

        // Pastikan stok_tersedia tidak lebih besar dari total_stok
        if ($validated['stok_tersedia'] > $validated['total_stok']) {
            $validated['stok_tersedia'] = $validated['total_stok'];
        }

        Item::create($validated);

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil ditambahkan!');
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
    public function edit(item $item)
    {
        $categories = Category::orderBy('nama')->get();
        return view('items.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, item $item)
    {
        $validated = $request->validate([
            'kode'            => 'required|string|max:50|unique:items,kode,' . $item->id,
            'nama'            => 'required|string|max:150',
            'deskripsi'       => 'nullable|string',
            'gambar'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stok_tersedia'   => 'required|integer|min:0',
            'total_stok'      => 'required|integer|min:1',
            'category_id'     => 'nullable|exists:categories,id',
            'status'          => 'required|in:tersedia,dipinjam,rusak,hilang',
            'kondisi'         => 'nullable|string|max:100',
        ]);

        // Handle upload gambar baru (ganti yang lama)
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($item->gambar) {
                Storage::disk('public')->delete($item->gambar);
            }
            $path = $request->file('gambar')->store('items', 'public');
            $validated['gambar'] = $path;
        }

        // Validasi stok
        if ($validated['stok_tersedia'] > $validated['total_stok']) {
            $validated['stok_tersedia'] = $validated['total_stok'];
        }

        $item->update($validated);

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(item $item)
    {
        if ($item->gambar) {
            Storage::disk('public')->delete($item->gambar);
        }

        $item->delete();

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil dihapus!');
    }
}
