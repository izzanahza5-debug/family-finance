<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // Tambahkan ini untuk validasi unik saat edit

class ManageUsers extends Component
{
    public $users;
    
    // Properti Form Tambah
    public $name = '';
    public $email = '';
    public $password = '';
    public $role = 'parent';

    // Properti Form Edit (Modal)
    public $editUserId;
    public $editName = '';
    public $editEmail = '';
    public $editRole = '';
    public $isEditModalOpen = false;

    public function mount()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = User::latest()->get();
    }

    public function createUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,parent',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        $this->reset(['name', 'email', 'password', 'role']);
        $this->loadUsers();
        session()->flash('message', 'Anggota keluarga baru berhasil didaftarkan!');
    }

    // Fungsi membuka modal dan mengisi data lama
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->editUserId = $user->id;
        $this->editName = $user->name;
        $this->editEmail = $user->email;
        $this->editRole = $user->role;
        
        $this->isEditModalOpen = true; // Munculkan Modal
    }

    // Fungsi menyimpan data edit
    public function updateUser()
    {
        $this->validate([
            'editName' => 'required|string|max:255',
            'editEmail' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->editUserId)],
            'editRole' => 'required|in:admin,parent',
        ]);

        // Cegah admin mengubah dirinya sendiri menjadi parent
        if (Auth::user()->id == $this->editUserId && $this->editRole !== 'admin') {
            session()->flash('error', 'Anda tidak bisa menurunkan jabatan (role) Anda sendiri!');
            $this->isEditModalOpen = false;
            return;
        }

        $user = User::findOrFail($this->editUserId);
        $user->update([
            'name' => $this->editName,
            'email' => $this->editEmail,
            'role' => $this->editRole,
        ]);

        $this->isEditModalOpen = false;
        $this->loadUsers();
        session()->flash('message', 'Data anggota berhasil diperbarui!');
    }

    public function closeEditModal()
    {
        $this->isEditModalOpen = false;
        $this->reset(['editUserId', 'editName', 'editEmail', 'editRole']);
    }

    public function deleteUser($userId)
    {
        if (Auth::user()->id == $userId) {
            session()->flash('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
            return;
        }

        User::destroy($userId);
        $this->loadUsers();
        session()->flash('message', 'Akun pengguna berhasil dihapus dari sistem.');
    }

    public function render()
    {
        return view('livewire.manage-users')->layout('layouts.app');
    }
}