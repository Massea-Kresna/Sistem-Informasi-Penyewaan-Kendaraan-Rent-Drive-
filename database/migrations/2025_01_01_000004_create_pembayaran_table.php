<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->increments('id_pembayaran');
            $table->unsignedInteger('id_sewa');
            $table->decimal('jumlah_bayar', 12, 2);
            $table->enum('metode_pembayaran', ['transfer', 'cash']);
            $table->date('tanggal_bayar');
            $table->string('bukti_transfer', 500)->nullable();
            $table->enum('status_pembayaran', ['pending', 'berhasil', 'gagal'])->default('pending');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_sewa')->references('id_sewa')->on('penyewaan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
