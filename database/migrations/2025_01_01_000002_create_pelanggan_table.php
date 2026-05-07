<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->increments('id_pelanggan');
            $table->string('nama', 150);
            $table->string('no_ktp', 30)->unique();
            $table->string('no_hp', 20);
            $table->string('alamat', 255);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
