<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // Kategori yang dibatasi (misal: Makanan)
            $table->decimal('amount', 12, 2); // Batas maksimal nominal uang
            $table->string('month_year'); // Format: YYYY-MM (misal: 2026-06) untuk batasan bulanan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};