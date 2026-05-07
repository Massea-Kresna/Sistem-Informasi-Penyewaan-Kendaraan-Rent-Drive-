<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mobil', function (Blueprint $table) {
            $table->increments('id_mobil');
            $table->string('nama_mobil', 100);
            $table->string('merek', 100);
            $table->string('plat_nomor', 20)->unique();
            $table->integer('harga_sewa');
            $table->enum('status', ['tersedia', 'disewa'])->default('tersedia');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobil');
    }
};
