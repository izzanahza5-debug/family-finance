<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination; // 1. Tambahkan ini

class ManageCategories extends Component
{
    use WithPagination; // 2. Gunakan trait ini

    public $activeTab = 'expense';

    // Properti Form Tambah & Edit tetap sama...
    public $name = '';
    public $type = 'expense';
    public $icon = '';
    public $color = '';
    public $editCategoryId;
    public $editName = '';
    public $editType = '';
    public $editIcon = '';
    public $editColor = '';
    public $isEditModalOpen = false;
    public $defaultIcons = ['🍔', '💵', '🚗', '🛍️', '🔌', '🍿', '🎓', '🏥', '🎮', '📈', '🎁', '📦', '🪙', '🏠', '🚌', '💖'];

    public function mount()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya Admin yang dapat mengelola kategori.');
        }
    }

    // 3. Reset halaman ke nomor 1 setiap kali ganti tab
    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage(); 
    }

    // Fungsi create, edit, update, delete tetap sama seperti sebelumnya...
    // (Pastikan fungsi-fungsi tersebut tetap ada di file Anda)

    public function createCategory() { /* ... kode sebelumnya ... */ }
    public function editCategory($id) { /* ... kode sebelumnya ... */ }
    public function updateCategory() { /* ... kode sebelumnya ... */ }
    public function deleteCategory($id) { /* ... kode sebelumnya ... */ }
    public function closeEditModal() { /* ... kode sebelumnya ... */ }

    public function render()
    {
        // 4. Ambil data dengan Paginate (Misal: 6 item per halaman)
        $categories = Category::where('type', $this->activeTab)
            ->latest()
            ->paginate(6);

        return view('livewire.manage-categories', [
            'filteredCategories' => $categories
        ])->layout('layouts.app');
    }
}