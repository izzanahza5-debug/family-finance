<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat akun Admin (Anda)
        User::factory()->create([
            'name' => 'Admin Kelola',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Membuat akun Ayah
        User::factory()->create([
            'name' => 'Ayah',
            'email' => 'ayah@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'parent',
        ]);

        // 3. Membuat akun Ibu
        User::factory()->create([
            'name' => 'Ibu',
            'email' => 'ibu@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'parent',
        ]);

        // Kategori Pengeluaran Default
        $expenses = [
            ['name' => 'Makanan & Minuman', 'icon' => '🍔', 'color' => '#f43f5e'],
            ['name' => 'Tagihan & Utilitas', 'icon' => '💡', 'color' => '#eab308'],
            ['name' => 'Transportasi', 'icon' => '🚗', 'color' => '#3b82f6'],
            ['name' => 'Belanja Bulanan', 'icon' => '🛒', 'color' => '#ec4899'],
            ['name' => 'Hiburan & Jajan', 'icon' => '🍿', 'color' => '#8b5cf6'],
            ['name' => 'Edukasi & Sekolah', 'icon' => '📚', 'color' => '#a855f7'],
            ['name' => 'Kesehatan', 'icon' => '🏥', 'color' => '#10b981'],
            ['name' => 'Hobi & Pribadi', 'icon' => '🎮', 'color' => '#6366f1'],
            ['name' => 'Lain-lain', 'icon' => '📦', 'color' => '#64748b'],
        ];

        foreach ($expenses as $exp) {
            Category::updateOrCreate(
                ['name' => $exp['name'], 'type' => 'expense'],
                ['icon' => $exp['icon'], 'color' => $exp['color']]
            );
        }

        // Kategori Pemasukan Default
        $incomes = [
            ['name' => 'Gaji Bulanan', 'icon' => '💵', 'color' => '#10b981'],
            ['name' => 'Bonus & THR', 'icon' => '🎁', 'color' => '#22c55e'],
            ['name' => 'Hasil Investasi', 'icon' => '📈', 'color' => '#06b6d4'],
            ['name' => 'Uang Saku', 'icon' => '👛', 'color' => '#14b8a6'],
            ['name' => 'Lain-lain', 'icon' => '🪙', 'color' => '#64748b'],
        ];

        foreach ($incomes as $inc) {
            Category::updateOrCreate(
                ['name' => $inc['name'], 'type' => 'income'],
                ['icon' => $inc['icon'], 'color' => $inc['color']]
            );
        }
    }
}