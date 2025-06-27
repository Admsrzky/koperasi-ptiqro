<?php 


// database/migrations/2024_01_01_000004_create_detail_potongan_pinjaman_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_potongan_pinjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penggajian_id')->constrained('penggajian')->onDelete('cascade');
            $table->foreignId('peminjaman_id')->constrained('peminjaman')->onDelete('cascade');
            $table->decimal('jumlah_potong', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_potongan_pinjaman');
    }
};