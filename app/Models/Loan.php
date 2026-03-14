<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'status',
        'catatan',
        'alamat_peminjam',
        'no_telepon',
    ];

    protected $casts = [
        'tanggal_pinjam'          => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual'  => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function isLate()
    {
        if ($this->status !== 'dipinjam') {
            return false;
        }
        return Carbon::today()->gt($this->tanggal_kembali_rencana);
    }

    public function statusBadge()
    {
        return match($this->status) {
            'pending'   => 'bg-gradient-warning',
            'dipinjam'  => 'bg-gradient-success',
            'kembali'   => 'bg-gradient-info',
            'dibatalkan' => 'bg-gradient-danger',
            default     => 'bg-gradient-secondary',
        };
    }
}
