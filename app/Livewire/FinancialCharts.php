<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class FinancialCharts extends Component
{
    public $startDate;
    public $endDate;

    public function mount()
    {
        // Default: Tanggal 1 bulan ini sampai hari ini
        $this->startDate = date('Y-m-01');
        $this->endDate = date('Y-m-d');
    }

    // Mendengarkan sinyal jika ada transaksi baru, agar grafik otomatis ter-update
    #[On('transaction-updated')]
    public function refreshCharts()
    {
        // Livewire akan otomatis memicu render ulang saat method ini dipanggil
    }

    private function getChartData($walletType)
    {
        $userId = Auth::id();

        // 1. Ambil query dasar berdasarkan tipe dompet dan rentang waktu
        $query = Transaction::where('wallet_type', $walletType)
            ->whereBetween('date', [$this->startDate, $this->endDate]);

        // Jika dompet pribadi, batasi hanya milik user yang sedang login
        if ($walletType === 'personal') {
            $query->where('user_id', $userId);
        }

        $transactions = $query->get();

        // 2. Hitung Total Cash Flow (Pemasukan vs Pengeluaran)
        $income = $transactions->where('type', 'income')->sum('amount');
        $expense = $transactions->where('type', 'expense')->sum('amount');

        // 3. Hitung Pengeluaran per Kategori untuk Grafik Donut
        $categoryData = $transactions->where('type', 'expense')
            ->groupBy('category')
            ->map(function ($items) {
                return $items->sum('amount');
            });

        return [
            'cashFlow' => [
                'labels' => ['Pemasukan', 'Pengeluaran'],
                'data' => [(float)$income, (float)$expense]
            ],
            'categories' => [
                'labels' => $categoryData->keys()->toArray(),
                'data' => $categoryData->values()->toArray()
            ]
        ];
    }

    public function render()
    {
        // Ambil data terpisah untuk masing-masing tab
        $familyData = $this->getChartData('family');
        $personalData = $this->getChartData('personal');

        return view('livewire.financial-charts', [
            'familyData' => $familyData,
            'personalData' => $personalData
        ]);
    }
}