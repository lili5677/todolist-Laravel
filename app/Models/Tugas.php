<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'user_id',
        'mata_kuliah_id',
        'judul_tugas',
        'tanggal',
        'status',
        'deskripsi',
        'catatan',
        'is_done',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_done' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }

    // Helper method untuk badge warna status
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'Belum Mulai' => 'bg-red-500',
            'Sedang Berlangsung' => 'bg-yellow-500',
            'Selesai' => 'bg-green-500',
            default => 'bg-gray-500',
        };
    }

    // Helper method untuk cek apakah tugas sudah lewat deadline
    public function isOverdue()
    {
        // Cek: tanggal deadline < hari ini (lewat) DAN status bukan "Selesai"
        // isPast() artinya tanggal sudah lewat dari hari ini
        return $this->tanggal->lt(Carbon::today()) && $this->status !== 'Selesai';
    }

    // Helper method untuk class CSS tanggal (merah kalau overdue)
    public function getDateColorClass()
    {
        return $this->isOverdue() ? 'text-red-600 font-bold' : 'text-gray-700';
    }
}