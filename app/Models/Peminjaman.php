<?php 


// app/Models/Peminjaman.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'nomor_pengajuan',
        'karyawan_id',
        'jumlah_pinjaman',
        'keperluan',
        'tanggal_pengajuan',
        'tanggal_cair',
        'status',
        'catatan',
        'file_pengajuan'
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_cair' => 'date',
        'jumlah_pinjaman' => 'decimal:2'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function detailPotongan()
    {
        return $this->hasMany(DetailPotonganPinjaman::class);
    }

    public static function generateNomorPengajuan()
    {
        $tahun = date('Y');
        $bulan = date('m');
        $lastNumber = self::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->count() + 1;
        
        return "PJM-{$tahun}{$bulan}-" . str_pad($lastNumber, 4, '0', STR_PAD_LEFT);
    }

    public function getTanggalCairOtomatisAttribute()
    {
        return $this->tanggal_pengajuan->addDays(5);
    }
}