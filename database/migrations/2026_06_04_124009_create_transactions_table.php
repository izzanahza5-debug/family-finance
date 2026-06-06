<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa yang mencatat
            $table->enum('type', ['income', 'expense']); // Pemasukan atau Pengeluaran
            $table->enum('wallet_type', ['family', 'personal']); // Dompet Keluarga atau Pribadi
            $table->string('category'); // Makanan, Tagihan, Hobi, dll
            $table->decimal('amount', 12, 2); // Nominal uang (mendukung ratusan juta rupiah)
            $table->date('date'); // Tanggal transaksi
            $table->text('note')->nullable(); // Catatan tambahan (opsional)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};