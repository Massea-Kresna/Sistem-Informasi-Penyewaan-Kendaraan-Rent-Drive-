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
            $table->string('email', 150)->unique();
            $table->string('password', 255);
            $table->string('foto_ktp', 500)->nullable();
            $table->date('tanggal_lahir');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
