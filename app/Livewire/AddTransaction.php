<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\Category; // Tambahkan import model Category
use Illuminate\Support\Facades\Auth;

class AddTransaction extends Component
{
    public $type = 'expense';
    public $wallet_type = 'family';
    public $category = '';
    public $amount = '';
    public $date = '';
    public $note = '';
    
    // Properti baru untuk fitur pencarian
    public $searchCategory = ''; 

    protected $rules = [
        'type' => 'required|in:income,expense',
        'wallet_type' => 'required|in:family,personal',
        'category' => 'required',
        'amount' => 'required|numeric|min:1',
        'date' => 'required|date',
        'note' => 'nullable|string|max:255',
    ];

    public function mount()
    {
        $this->date = date('Y-m-d');
    }

    // Reset kategori dan kolom pencarian setiap kali radio button tipe (Pemasukan/Pengeluaran) diubah
    public function updatedType()
    {
        $this->category = '';
        $this->searchCategory = '';
    }

    public function save()
    {
        $this->validate();

        Transaction::create([
            'user_id' => Auth::id(),
            'type' => $this->type,
            'wallet_type' => $this->wallet_type,
            'category' => $this->category,
            'amount' => $this->amount,
            'date' => $this->date,
            'note' => $this->note,
        ]);

        $this->dispatch('transaction-updated');

        // Reset form termasuk fitur pencarian
        $this->reset(['category', 'amount', 'note', 'searchCategory']);
        
        session()->flash('message', 'Transaksi berhasil dicatat!');
    }

    public function render()
    {
        // Query kategori dinamis berdasarkan radio button yang aktif & kata kunci pencarian
        $categories = Category::where('type', $this->type)
            ->where('name', 'like', '%' . $this->searchCategory . '%')
            ->orderBy('name', 'asc')
            ->get();

        return view('livewire.add-transaction', [
            'categories' => $categories
        ]);
    }
}