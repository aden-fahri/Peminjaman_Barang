<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'gambar',
        'stok_tersedia',
        'category_id',
        'status',
        'total_stok',
        'kondisi',
    ];

    protected $casts = [
        'stok_tersedia' => 'integer',
        'total_stok'    => 'integer',
    ];

    // Relasi Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // cek apakah stok hampir habis
    public function isLowStock(): bool
    {
        return $this->stok_tersedia <= 2;
    }

    // label status dengan warna badge
    public function statusBadge(): string
    {
        return match ($this->status) {
            'tersedia' => 'bg-success',
            'dipinjam' => 'bg-warning',
            'rusak'    => 'bg-danger',
            'hilang'   => 'bg-dark',
            default    => 'bg-secondary',
        };
    }
}
