<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class FinancialSummary extends Component
{
    // Memicu render ulang otomatis saat ada event transaksi baru
    #[On('transaction-updated')]
    public function refreshData()
    {
        // Fungsi ini dibiarkan kosong, Livewire otomatis memicu render()
    }

    public function render()
    {
        $user = Auth::user();
        $currentMonth = date('Y-m');

        // 1. Hitung Saldo Dompet Keluarga
        $familyIncome = Transaction::where('wallet_type', 'family')->where('type', 'income')->sum('amount');
        $familyExpense = Transaction::where('wallet_type', 'family')->where('type', 'expense')->sum('amount');
        $familyBalance = $familyIncome - $familyExpense;

        // 2. Hitung Saldo Dompet Pribadi
        $personalIncome = Transaction::where('wallet_type', 'personal')->where('user_id', $user->id)->where('type', 'income')->sum('amount');
        $personalExpense = Transaction::where('wallet_type', 'personal')->where('user_id', $user->id)->where('type', 'expense')->sum('amount');
        $personalBalance = $personalIncome - $personalExpense;

        // 3. Ambil 5 Transaksi Terakhir
        $recentTransactions = Transaction::where(function($query) use ($user) {
            $query->where('wallet_type', 'family')
                  ->orWhere(function($q) use ($user) {
                      $q->where('wallet_type', 'personal')->where('user_id', $user->id);
                  });
        })
        ->with('user')
        ->latest()
        ->take(8)
        ->get();

        // 4. LOGIKA BARU: Hitung Penggunaan Anggaran Bulanan (Hanya untuk transaksi tipe 'family')
        $activeBudgets = Budget::where('month_year', $currentMonth)->get();
        
        $budgetStatuses = $activeBudgets->map(function ($budget) use ($currentMonth) {
            // Hitung total pengeluaran nyata keluarga untuk kategori ini di bulan berjalan
            $totalSpent = Transaction::where('wallet_type', 'family')
                ->where('type', 'expense')
                ->where('category', $budget->category)
                ->where('date', 'like', $currentMonth . '%')
                ->sum('amount');

            // Hitung persentase pemakaian
            $percentage = $budget->amount > 0 ? ($totalSpent / $budget->amount) * 100 : 0;

            // Tentukan warna indikator berdasarkan persentase
            if ($percentage >= 100) {
                $color = 'bg-rose-600'; // Overbudget (Merah)
                $textColor = 'text-rose-600';
            } elseif ($percentage >= 80) {
                $color = 'bg-amber-500'; // Peringatan (Kuning/Amber)
                $textColor = 'text-amber-600';
            } else {
                $color = 'bg-emerald-500'; // Aman (Hijau)
                $textColor = 'text-emerald-600';
            }

            return [
                'category' => $budget->category,
                'limit' => (float) $budget->amount,
                'spent' => (float) $totalSpent,
                'percentage' => min($percentage, 100), // Batasi visual progress bar maks 100%
                'real_percentage' => $percentage,
                'color' => $color,
                'textColor' => $textColor
            ];
        });

        return view('livewire.financial-summary', [
            'familyBalance' => $familyBalance,
            'personalBalance' => $personalBalance,
            'recentTransactions' => $recentTransactions,
            'budgetStatuses' => $budgetStatuses, // Lempar ke view
        ]);
    }
}