<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Budget;
use App\Models\Category; // Tambahkan import Model Category
use Illuminate\Support\Facades\Auth;

class ManageBudgets extends Component
{
    public $budgets;
    public $category = '';
    public $amount = '';
    public $month_year = '';
    
    // Properti khusus pencarian (Search)
    public $searchCategory = '';

    public function mount()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $this->month_year = date('Y-m');
        $this->loadBudgets();
    }

    public function loadBudgets()
    {
        $this->budgets = Budget::where('month_year', $this->month_year)->get();
    }

    public function updatedMonthYear()
    {
        $this->loadBudgets();
    }

    public function saveBudget()
    {
        $this->validate([
            'category' => 'required',
            'amount' => 'required|numeric|min:1',
            'month_year' => 'required|string',
        ]);

        Budget::updateOrCreate(
            [
                'category' => $this->category,
                'month_year' => $this->month_year
            ],
            [
                'amount' => $this->amount
            ]
        );

        // Reset state
        $this->reset(['category', 'amount', 'searchCategory']);
        $this->loadBudgets();
        
        session()->flash('message', 'Anggaran berhasil disimpan!');
    }

    public function deleteBudget($id)
    {
        Budget::destroy($id);
        $this->loadBudgets();
        session()->flash('message', 'Anggaran berhasil dihapus.');
    }

    public function render()
    {
        // Hanya muat kategori PENGELUARAN untuk form budgeting
        $categories = Category::where('type', 'expense')
            ->where('name', 'like', '%' . $this->searchCategory . '%')
            ->orderBy('name', 'asc')
            ->get();

        return view('livewire.manage-budgets', [
            'categories' => $categories
        ])->layout('layouts.app');
    }
}