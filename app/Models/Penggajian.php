<?php

// app/Models/Penggajian.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    use HasFactory;

    protected $table = 'penggajian';

    protected $fillable = [
        'karyawan_id',
        'periode',
        'gaji_pokok',
        'tunjangan',
        'lembur',
        'bonus',
        'potongan_pinjaman',
        'potongan_lain',
        'total_gaji',
        'status'
    ];

    protected $casts = [
        'gaji_pokok' => 'decimal:2',
        'tunjangan' => 'decimal:2',
        'lembur' => 'decimal:2',
        'bonus' => 'decimal:2',
        'potongan_pinjaman' => 'decimal:2',
        'potongan_lain' => 'decimal:2',
        'total_gaji' => 'decimal:2'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function detailPotonganPinjaman()
    {
        return $this->hasMany(DetailPotonganPinjaman::class);
    }

    public function hitungTotalGaji()
    {
        $this->total_gaji = ($this->gaji_pokok + $this->tunjangan + $this->lembur + $this->bonus)
            - ($this->potongan_pinjaman + $this->potongan_lain);
        return $this->total_gaji;
    }
}