<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penyewaan', function (Blueprint $table) {
            $table->increments('id_sewa');
            $table->unsignedInteger('id_mobil');
            $table->unsignedInteger('id_pelanggan');
            $table->date('tanggal_sewa');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status', ['pending', 'dibayar', 'selesai', 'dibatalkan'])->default('pending');
            $table->integer('total_biaya')->nullable();

            $table->foreign('id_mobil')->references('id_mobil')->on('mobil');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyewaan');
    }
};
