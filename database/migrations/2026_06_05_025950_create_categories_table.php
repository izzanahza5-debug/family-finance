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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['income', 'expense']);
            $table->string('icon')->nullable(); // Menyimpan emoji atau icon class FontAwesome
            $table->string('color')->nullable(); // Menyimpan kode warna HEX (misal: #6366f1)
            $table->timestamps();
        });

        // Modifikasi tabel transactions agar terhubung ke tabel categories secara opsional (nullable)
        // untuk menjaga backward compatibility dengan data transaksi yang sudah terlanjur ada sebelumnya.
        if (Schema::hasTable('transactions')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->foreignId('category_id')->nullable()->after('user_id')->constrained('categories')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('transactions')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            });
        }
        Schema::dropIfExists('categories');
    }
};