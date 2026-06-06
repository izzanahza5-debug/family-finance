<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id', // Menambahkan kolom relasi baru
        'type',
        'wallet_type',
        'category', // Tetap dipertahankan sebagai cadangan nama teks kategori
        'amount',
        'date',
        'note'
    ];

    // Hubungan: 1 Transaksi dimiliki oleh 1 User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Hubungan ke Kategori Dinamis
    public function categoryRelation(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}