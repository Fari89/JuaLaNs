<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Menambahkan kolom 'kategori' sebagai string yang bisa kosong
            // setelah kolom 'deskripsi' (opsional)
            $table->string('kategori')->nullable()->after('deskripsi');
            // Jika setiap produk harus punya kategori, hapus ->nullable()
            // $table->string('kategori')->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Menghapus kolom 'kategori' jika migrasi di-rollback
            $table->dropColumn('kategori');
        });
    }
};