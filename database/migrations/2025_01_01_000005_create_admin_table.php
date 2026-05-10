<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->increments('id_admin');
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->string('nama', 150);
            $table->timestamp('created_at')->useCurrent();
        });

        // Default admin: username=admin, password=admin123
        DB::table('admin')->insert([
            'username'   => 'admin',
            'password'   => Hash::make('admin123'),
            'nama'       => 'Administrator',
            'created_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
