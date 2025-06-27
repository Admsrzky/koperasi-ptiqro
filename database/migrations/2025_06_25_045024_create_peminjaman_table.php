<?php 


// database/migrations/2024_01_01_000002_create_peminjaman_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pengajuan')->unique();
            $table->foreignId('karyawan_id')->constrained('karyawan')->onDelete('cascade');
            $table->decimal('jumlah_pinjaman', 15, 2);
            $table->text('keperluan');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_cair')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'dicairkan'])->default('pending');
            $table->text('catatan')->nullable();
            $table->string('file_pengajuan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peminjaman');
    }
};