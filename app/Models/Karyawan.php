<?php

// app/Models/Karyawan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $fillable = [
        'nip',
        'nama',
        'email',
        'telepon',
        'jabatan',
        'departemen',
        'gaji_pokok',
        'tunjangan',
        'tanggal_masuk',
        'status'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'gaji_pokok' => 'decimal:2',
        'tunjangan' => 'decimal:2'
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function penggajian()
    {
        return $this->hasMany(Penggajian::class);
    }

    public function getTotalGajiAttribute()
    {
        return $this->gaji_pokok + $this->tunjangan;
    }

    public function getPinjamanAktifAttribute()
    {
        return $this->peminjaman()
            ->whereIn('status', ['disetujui', 'dicairkan'])
            ->sum('jumlah_pinjaman');
    }
}