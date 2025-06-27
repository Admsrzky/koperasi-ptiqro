<?php 



// app/Models/DetailPotonganPinjaman.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPotonganPinjaman extends Model
{
    use HasFactory;

    protected $table = 'detail_potongan_pinjaman';

    protected $fillable = [
        'penggajian_id',
        'peminjaman_id',
        'jumlah_potong'
    ];

    protected $casts = [
        'jumlah_potong' => 'decimal:2'
    ];

    public function penggajian()
    {
        return $this->belongsTo(Penggajian::class);
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}