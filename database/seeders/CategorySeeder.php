<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Income categories
            ['name' => 'Penjualan Produk', 'type' => 'income', 'icon' => 'shopping-bag', 'color' => '#10b981', 'is_system' => true],
            ['name' => 'Penjualan Jasa', 'type' => 'income', 'icon' => 'briefcase', 'color' => '#3b82f6', 'is_system' => true],
            ['name' => 'Pendapatan Lainnya', 'type' => 'income', 'icon' => 'plus-circle', 'color' => '#8b5cf6', 'is_system' => true],

            // Expense categories
            ['name' => 'Pembelian Bahan Baku', 'type' => 'expense', 'icon' => 'cube', 'color' => '#ef4444', 'is_system' => true],
            ['name' => 'Gaji Karyawan', 'type' => 'expense', 'icon' => 'users', 'color' => '#f59e0b', 'is_system' => true],
            ['name' => 'Sewa Tempat', 'type' => 'expense', 'icon' => 'home', 'color' => '#6366f1', 'is_system' => true],
            ['name' => 'Listrik & Air', 'type' => 'expense', 'icon' => 'lightning-bolt', 'color' => '#eab308', 'is_system' => true],
            ['name' => 'Transportasi', 'type' => 'expense', 'icon' => 'truck', 'color' => '#14b8a6', 'is_system' => true],
            ['name' => 'Marketing & Promosi', 'type' => 'expense', 'icon' => 'speakerphone', 'color' => '#ec4899', 'is_system' => true],
            ['name' => 'Perlengkapan Kantor', 'type' => 'expense', 'icon' => 'office-building', 'color' => '#64748b', 'is_system' => true],
            ['name' => 'Pajak & Perizinan', 'type' => 'expense', 'icon' => 'document-text', 'color' => '#0ea5e9', 'is_system' => true],
            ['name' => 'Pengeluaran Lainnya', 'type' => 'expense', 'icon' => 'dots-horizontal', 'color' => '#78716c', 'is_system' => true],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
