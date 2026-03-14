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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('restrict');
            $table->date('tanggal_pinjam')->useCurrent();
            $table->date('tanggal_kembali_rencana');
            $table->date('tanggal_kembali_aktual')->nullable(); 
            $table->enum('status', ['pending', 'dipinjam', 'dikembalikan', 'terlambat', 'dibatalkan'])->default('pending');
            $table->text('catatan')->nullable();
            $table->text('alamat_peminjam')->nullable();
            $table->string('no_telepon', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
