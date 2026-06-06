<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class TransactionReports extends Component
{
    use WithPagination;

    // Properti Filter
    public $startDate;
    public $endDate;
    public $category = '';
    public $walletType = '';
    public $userId = ''; // Khusus Admin untuk memantau user lain

    protected $queryString = [
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'category' => ['except' => ''],
        'walletType' => ['except' => ''],
        'userId' => ['except' => ''],
    ];

    public function updatingFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['startDate', 'endDate', 'category', 'walletType', 'userId']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Transaction::query()->with('user');

        // ── KENDALI HAK AKSES PRIVASI VS TRANSPARANSI ──
        if (Auth::user()->role !== 'admin') {
            // Pengguna Biasa (Parent): Hanya bisa melihat seluruh transaksi Dompet Keluarga 
            // DAN transaksi Dompet Pribadi miliknya sendiri.
            $query->where(function($q) {
                $q->where('wallet_type', 'family')
                  ->orWhere('user_id', Auth::id());
            });
        } else {
            // ADMIN MASTER ACCESS: Bisa melihat segalanya, terhitung transaksi pribadi milik user lain.
            // Saring berdasarkan Anggota Keluarga tertentu jika dipilih oleh Admin
            if ($this->userId) {
                $query->where('user_id', $this->userId);
            }
        }

        // Filter Rentang Tanggal
        if ($this->startDate) {
            $query->where('date', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->where('date', '<=', $this->endDate);
        }

        // Filter Kategori Konten
        if ($this->category) {
            $query->where('category', $this->category);
        }

        // Filter Jenis Dompet
        if ($this->walletType) {
            $query->where('wallet_type', $this->walletType);
        }

        // Ambil list data pembantu untuk komponen filter dropdown
        $allUsers = User::orderBy('name', 'asc')->get();
        
        // Ambil kategori unik yang terdaftar dari database Anda
        $distinctCategories = Transaction::distinct()->pluck('category');

        return view('livewire.transaction-reports', [
            'transactions' => $query->latest('date')->latest('id')->paginate(15),
            'allUsers' => $allUsers,
            'distinctCategories' => $distinctCategories
        ])->layout('layouts.app');
    }
}