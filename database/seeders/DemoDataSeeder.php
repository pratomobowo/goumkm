<?php

namespace Database\Seeders;

use App\Enums\TransactionType;
use App\Models\Budget;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = 1;
        $userId = 2;

        // Sample Transactions (last 3 months)
        $transactions = [
            // December Income
            ['date' => '2025-12-20', 'description' => 'Penjualan Produk A', 'amount' => 5500000, 'type' => 'income', 'category_id' => 1],
            ['date' => '2025-12-18', 'description' => 'Penjualan Jasa Konsultasi', 'amount' => 2000000, 'type' => 'income', 'category_id' => 2],
            ['date' => '2025-12-15', 'description' => 'Penjualan Produk B', 'amount' => 3200000, 'type' => 'income', 'category_id' => 1],
            ['date' => '2025-12-10', 'description' => 'Pendapatan Ongkir', 'amount' => 450000, 'type' => 'income', 'category_id' => 3],
            
            // December Expense
            ['date' => '2025-12-19', 'description' => 'Beli Bahan Baku', 'amount' => 2500000, 'type' => 'expense', 'category_id' => 4],
            ['date' => '2025-12-15', 'description' => 'Gaji Karyawan', 'amount' => 4000000, 'type' => 'expense', 'category_id' => 5],
            ['date' => '2025-12-05', 'description' => 'Bayar Listrik', 'amount' => 650000, 'type' => 'expense', 'category_id' => 7],
            ['date' => '2025-12-01', 'description' => 'Sewa Tempat', 'amount' => 2000000, 'type' => 'expense', 'category_id' => 6],

            // November
            ['date' => '2025-11-25', 'description' => 'Penjualan Produk C', 'amount' => 4800000, 'type' => 'income', 'category_id' => 1],
            ['date' => '2025-11-20', 'description' => 'Penjualan Jasa', 'amount' => 1500000, 'type' => 'income', 'category_id' => 2],
            ['date' => '2025-11-15', 'description' => 'Gaji Karyawan', 'amount' => 4000000, 'type' => 'expense', 'category_id' => 5],
            ['date' => '2025-11-10', 'description' => 'Beli Bahan Baku', 'amount' => 1800000, 'type' => 'expense', 'category_id' => 4],

            // October
            ['date' => '2025-10-28', 'description' => 'Penjualan Besar', 'amount' => 8500000, 'type' => 'income', 'category_id' => 1],
            ['date' => '2025-10-20', 'description' => 'Jasa Desain', 'amount' => 2500000, 'type' => 'income', 'category_id' => 2],
            ['date' => '2025-10-15', 'description' => 'Gaji Karyawan', 'amount' => 4000000, 'type' => 'expense', 'category_id' => 5],
            ['date' => '2025-10-05', 'description' => 'Marketing Online', 'amount' => 1200000, 'type' => 'expense', 'category_id' => 9],
        ];

        foreach ($transactions as $t) {
            Transaction::create([
                'tenant_id' => $tenantId,
                'user_id' => $userId,
                'category_id' => $t['category_id'],
                'date' => $t['date'],
                'description' => $t['description'],
                'amount' => $t['amount'],
                'type' => $t['type'],
                'is_taxable' => true,
            ]);
        }

        // Sample Products
        $products = [
            ['sku' => 'PRD001', 'name' => 'Produk A - Premium', 'unit' => 'pcs', 'purchase_price' => 50000, 'selling_price' => 75000, 'current_stock' => 25, 'min_stock' => 10],
            ['sku' => 'PRD002', 'name' => 'Produk B - Standard', 'unit' => 'pcs', 'purchase_price' => 30000, 'selling_price' => 45000, 'current_stock' => 8, 'min_stock' => 15],
            ['sku' => 'PRD003', 'name' => 'Produk C - Economy', 'unit' => 'pcs', 'purchase_price' => 15000, 'selling_price' => 25000, 'current_stock' => 50, 'min_stock' => 20],
            ['sku' => 'BHN001', 'name' => 'Bahan Baku Utama', 'unit' => 'kg', 'purchase_price' => 25000, 'selling_price' => 0, 'current_stock' => 5, 'min_stock' => 10],
        ];

        foreach ($products as $p) {
            Product::create(array_merge($p, ['tenant_id' => $tenantId]));
        }

        // Sample Budgets
        $budgets = [
            ['name' => 'Target Penjualan', 'type' => 'income', 'period_month' => 12, 'period_year' => 2025, 'planned_amount' => 15000000],
            ['name' => 'Anggaran Gaji', 'type' => 'expense', 'period_month' => 12, 'period_year' => 2025, 'planned_amount' => 5000000, 'category_id' => 5],
            ['name' => 'Anggaran Operasional', 'type' => 'expense', 'period_month' => 12, 'period_year' => 2025, 'planned_amount' => 3000000],
        ];

        foreach ($budgets as $b) {
            Budget::create(array_merge($b, ['tenant_id' => $tenantId]));
        }
    }
}
