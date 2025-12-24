<?php

namespace Database\Seeders;

use App\Enums\TransactionType;
use App\Enums\StockMovementType;
use App\Models\Account;
use App\Models\Budget;
use App\Models\Category;
use App\Models\JournalEntry;
use App\Models\JournalLine;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Tenant;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RealisticDemoSeeder extends Seeder
{
    private int $tenantId;
    private int $userId;
    private array $accounts = [];
    private array $categories = [];
    private int $journalSequence = 1;

    public function run(): void
    {
        // Reset existing data
        DB::statement('PRAGMA foreign_keys = OFF');
        JournalLine::truncate();
        JournalEntry::truncate();
        StockMovement::truncate();
        Product::where('tenant_id', 1)->delete();
        Transaction::where('tenant_id', 1)->delete();
        Budget::where('tenant_id', 1)->delete();
        DB::statement('PRAGMA foreign_keys = ON');

        // Update tenant info
        $tenant = Tenant::find(1);
        $tenant->update([
            'name' => 'Sepatu Berkah Jaya',
            'business_type' => 'Produksi',
            'npwp' => '12.345.678.9-123.000',
            'address' => 'Jl. Industri Kecil No. 45, Cibaduyut, Bandung',
            'phone' => '022-12345678',
            'email' => 'info@sepatuberkah.com',
            'has_inventory' => true,
        ]);

        $this->tenantId = 1;
        $this->userId = 2;

        // Load accounts
        $this->accounts = Account::where('tenant_id', $this->tenantId)
            ->pluck('id', 'code')
            ->toArray();

        // Create Categories
        $this->createCategories();

        // Load categories
        $this->categories = Category::where('tenant_id', $this->tenantId)
            ->pluck('id', 'name')
            ->toArray();

        // Create Products
        $this->createProducts();

        // Create Stock Movements
        $this->createStockMovements();

        // Create Budgets for 6 months
        $this->createBudgets();

        // Create transactions and journals for 6 months (Jul-Dec 2025)
        $this->createMonthlyData();

        $this->command->info('✓ Demo data "Sepatu Berkah Jaya" created successfully!');
    }

    private function createCategories(): void
    {
        // Delete existing categories for tenant
        Category::where('tenant_id', $this->tenantId)->delete();

        $categories = [
            // Pendapatan
            ['name' => 'Penjualan Produk', 'type' => 'income', 'is_system' => true],
            ['name' => 'Penjualan Jasa', 'type' => 'income', 'is_system' => true],
            ['name' => 'Pendapatan Lain-lain', 'type' => 'income', 'is_system' => false],

            // Pengeluaran
            ['name' => 'Pembelian Bahan', 'type' => 'expense', 'is_system' => true],
            ['name' => 'Gaji Karyawan', 'type' => 'expense', 'is_system' => true],
            ['name' => 'Sewa', 'type' => 'expense', 'is_system' => true],
            ['name' => 'Listrik & Air', 'type' => 'expense', 'is_system' => true],
            ['name' => 'Transportasi', 'type' => 'expense', 'is_system' => false],
            ['name' => 'Marketing', 'type' => 'expense', 'is_system' => false],
            ['name' => 'Perawatan & Perbaikan', 'type' => 'expense', 'is_system' => false],
            ['name' => 'Biaya Lain-lain', 'type' => 'expense', 'is_system' => false],
        ];

        foreach ($categories as $cat) {
            Category::create(array_merge($cat, ['tenant_id' => $this->tenantId]));
        }
    }

    private function createProducts(): void
    {
        $products = [
            ['sku' => 'SPT001', 'name' => 'Sepatu Kulit Pria Formal', 'unit' => 'pcs', 'purchase_price' => 180000, 'selling_price' => 350000, 'current_stock' => 25, 'min_stock' => 10],
            ['sku' => 'SPT002', 'name' => 'Sepatu Kulit Wanita Heels', 'unit' => 'pcs', 'purchase_price' => 150000, 'selling_price' => 300000, 'current_stock' => 18, 'min_stock' => 8],
            ['sku' => 'SPT003', 'name' => 'Sandal Kulit Premium', 'unit' => 'pcs', 'purchase_price' => 80000, 'selling_price' => 175000, 'current_stock' => 35, 'min_stock' => 15],
            ['sku' => 'SPT004', 'name' => 'Sepatu Boots Kulit', 'unit' => 'pcs', 'purchase_price' => 250000, 'selling_price' => 500000, 'current_stock' => 12, 'min_stock' => 5],
            ['sku' => 'SPT005', 'name' => 'Sepatu Casual Slip-on', 'unit' => 'pcs', 'purchase_price' => 120000, 'selling_price' => 250000, 'current_stock' => 20, 'min_stock' => 10],
            ['sku' => 'BHN001', 'name' => 'Kulit Sapi Grade A', 'unit' => 'lembar', 'purchase_price' => 150000, 'selling_price' => 0, 'current_stock' => 8, 'min_stock' => 20],
            ['sku' => 'BHN002', 'name' => 'Sol Karet Premium', 'unit' => 'pcs', 'purchase_price' => 25000, 'selling_price' => 0, 'current_stock' => 45, 'min_stock' => 50],
            ['sku' => 'BHN003', 'name' => 'Lem Sepatu Industrial', 'unit' => 'kg', 'purchase_price' => 85000, 'selling_price' => 0, 'current_stock' => 3, 'min_stock' => 5],
        ];

        foreach ($products as $p) {
            Product::create(array_merge($p, ['tenant_id' => $this->tenantId]));
        }
    }

    private function createStockMovements(): void
    {
        $products = Product::where('tenant_id', $this->tenantId)->get();
        
        // Create stock movements for last 3 months
        for ($i = 2; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            foreach ($products as $product) {
                // Stock In - Pembelian/Produksi
                if (rand(0, 1)) {
                    $qty = rand(10, 30);
                    $stockDate = $date->copy()->day(rand(1, 10));
                    StockMovement::create([
                        'tenant_id' => $this->tenantId,
                        'product_id' => $product->id,
                        'user_id' => $this->userId,
                        'type' => 'in',
                        'quantity' => $qty,
                        'date' => $stockDate->format('Y-m-d'),
                        'reference' => 'PO-' . $year . $month . '-' . rand(100, 999),
                        'notes' => 'Pembelian dari supplier',
                    ]);
                }
                
                // Stock Out - Penjualan
                if ($product->selling_price > 0) {
                    $qty = rand(5, 20);
                    $stockDate = $date->copy()->day(rand(15, 25));
                    StockMovement::create([
                        'tenant_id' => $this->tenantId,
                        'product_id' => $product->id,
                        'user_id' => $this->userId,
                        'type' => 'out',
                        'quantity' => $qty,
                        'date' => $stockDate->format('Y-m-d'),
                        'reference' => 'SO-' . $year . $month . '-' . rand(100, 999),
                        'notes' => 'Penjualan ke pelanggan',
                    ]);
                }
                
                // Bahan baku - usage
                if ($product->selling_price == 0) {
                    $qty = rand(3, 10);
                    $stockDate = $date->copy()->day(rand(10, 20));
                    StockMovement::create([
                        'tenant_id' => $this->tenantId,
                        'product_id' => $product->id,
                        'user_id' => $this->userId,
                        'type' => 'out',
                        'quantity' => $qty,
                        'date' => $stockDate->format('Y-m-d'),
                        'reference' => 'PRD-' . $year . $month . '-' . rand(100, 999),
                        'notes' => 'Pemakaian produksi',
                    ]);
                }
            }
        }
    }

    private function createBudgets(): void
    {
        // Create budgets for last 6 months from current date
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            $idx = 5 - $i; // 0 to 5
            
            // Target Penjualan - increasing each month (higher values for tax)
            Budget::create([
                'tenant_id' => $this->tenantId,
                'name' => 'Target Penjualan',
                'type' => 'income',
                'period_month' => $month,
                'period_year' => $year,
                'planned_amount' => 50000000 + ($idx * 5000000), // 50jt - 75jt
            ]);

            // Anggaran Gaji
            Budget::create([
                'tenant_id' => $this->tenantId,
                'name' => 'Anggaran Gaji',
                'type' => 'expense',
                'period_month' => $month,
                'period_year' => $year,
                'planned_amount' => 12000000,
                'category_id' => $this->categories['Gaji Karyawan'] ?? null,
            ]);

            // Anggaran Bahan Baku
            Budget::create([
                'tenant_id' => $this->tenantId,
                'name' => 'Anggaran Bahan Baku',
                'type' => 'expense',
                'period_month' => $month,
                'period_year' => $year,
                'planned_amount' => 18000000,
                'category_id' => $this->categories['Pembelian Bahan'] ?? null,
            ]);

            // Anggaran Operasional
            Budget::create([
                'tenant_id' => $this->tenantId,
                'name' => 'Anggaran Operasional',
                'type' => 'expense',
                'period_month' => $month,
                'period_year' => $year,
                'planned_amount' => 5000000,
            ]);
        }
    }

    private function createMonthlyData(): void
    {
        // Use last 6 months from current date for proper chart display
        // Total: 45+52+58+65+72+95 = 387 million (6 months) = ~774 million annually -> Taxable
        $salesData = [45000000, 52000000, 58000000, 65000000, 72000000, 95000000];
        $ordersData = [150, 175, 195, 220, 245, 320];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $data = [
                'sales' => $salesData[5 - $i],
                'orders' => $ordersData[5 - $i]
            ];
            
            $this->createMonthTransactions($month, $year, $data);
        }
    }

    private function createMonthTransactions(int $month, int $year, array $data): void
    {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // === INCOME TRANSACTIONS ===
        
        // Split sales into multiple transactions throughout the month
        $salesDays = [3, 7, 10, 14, 17, 21, 24, 28];
        $salesPerDay = $data['sales'] / count($salesDays);
        
        foreach ($salesDays as $i => $day) {
            if ($day > $daysInMonth) continue;
            
            $amount = round($salesPerDay + rand(-500000, 500000), -3);
            $date = sprintf('%d-%02d-%02d', $year, $month, $day);
            
            // Transaction
            $tx = Transaction::create([
                'tenant_id' => $this->tenantId,
                'user_id' => $this->userId,
                'category_id' => $this->categories['Penjualan Produk'] ?? 1,
                'date' => $date,
                'description' => 'Penjualan sepatu - Order batch ' . ($i + 1),
                'amount' => $amount,
                'type' => 'income',
                'is_taxable' => true,
            ]);

            // Journal: Kas (D) / Penjualan (C)
            $this->createJournal($date, 'Penerimaan kas dari penjualan sepatu batch ' . ($i + 1), [
                ['account' => '1100', 'debit' => $amount, 'credit' => 0], // Kas
                ['account' => '4100', 'debit' => 0, 'credit' => $amount], // Penjualan
            ], $tx->id);
        }

        // Pendapatan Jasa (repair/custom)
        $serviceIncome = rand(800000, 1500000);
        $tx = Transaction::create([
            'tenant_id' => $this->tenantId,
            'user_id' => $this->userId,
            'category_id' => $this->categories['Penjualan Jasa'] ?? 2,
            'date' => sprintf('%d-%02d-15', $year, $month),
            'description' => 'Jasa perbaikan & custom sepatu',
            'amount' => $serviceIncome,
            'type' => 'income',
            'is_taxable' => true,
        ]);

        $this->createJournal(sprintf('%d-%02d-15', $year, $month), 'Penerimaan jasa perbaikan sepatu', [
            ['account' => '1100', 'debit' => $serviceIncome, 'credit' => 0],
            ['account' => '4200', 'debit' => 0, 'credit' => $serviceIncome],
        ], $tx->id);

        // === EXPENSE TRANSACTIONS ===

        // 1. Gaji Karyawan (tanggal 25) - 6 karyawan
        $gajiTotal = 12000000;
        $tx = Transaction::create([
            'tenant_id' => $this->tenantId,
            'user_id' => $this->userId,
            'category_id' => $this->categories['Gaji Karyawan'] ?? 5,
            'date' => sprintf('%d-%02d-25', $year, $month),
            'description' => 'Pembayaran gaji 6 karyawan',
            'amount' => $gajiTotal,
            'type' => 'expense',
            'is_taxable' => false,
        ]);

        $this->createJournal(sprintf('%d-%02d-25', $year, $month), 'Pembayaran gaji karyawan bulan ' . $this->getMonthName($month), [
            ['account' => '5200', 'debit' => $gajiTotal, 'credit' => 0], // Beban Gaji
            ['account' => '1100', 'debit' => 0, 'credit' => $gajiTotal], // Kas
        ], $tx->id);

        // 2. Pembelian Bahan Baku (beberapa kali) - larger amounts
        $bahanBakuDays = [5, 12, 20];
        foreach ($bahanBakuDays as $i => $day) {
            if ($day > $daysInMonth) continue;
            
            $amount = rand(5000000, 7000000);
            $items = ['Kulit sapi 20 lembar', 'Sol karet 100 pcs + lem industrial', 'Benang, jarum, aksesoris lengkap'];
            
            $tx = Transaction::create([
                'tenant_id' => $this->tenantId,
                'user_id' => $this->userId,
                'category_id' => $this->categories['Pembelian Bahan'] ?? 4,
                'date' => sprintf('%d-%02d-%02d', $year, $month, $day),
                'description' => 'Beli bahan baku: ' . $items[$i],
                'amount' => $amount,
                'type' => 'expense',
                'is_taxable' => false,
            ]);

            $this->createJournal(sprintf('%d-%02d-%02d', $year, $month, $day), 'Pembelian bahan baku - ' . $items[$i], [
                ['account' => '1300', 'debit' => $amount, 'credit' => 0], // Persediaan
                ['account' => '1100', 'debit' => 0, 'credit' => $amount], // Kas
            ], $tx->id);
        }

        // 3. Sewa Tempat (tanggal 1)
        $sewa = 3000000;
        $tx = Transaction::create([
            'tenant_id' => $this->tenantId,
            'user_id' => $this->userId,
            'category_id' => $this->categories['Sewa'] ?? 6,
            'date' => sprintf('%d-%02d-01', $year, $month),
            'description' => 'Bayar sewa workshop',
            'amount' => $sewa,
            'type' => 'expense',
            'is_taxable' => false,
        ]);

        $this->createJournal(sprintf('%d-%02d-01', $year, $month), 'Pembayaran sewa workshop bulan ' . $this->getMonthName($month), [
            ['account' => '5300', 'debit' => $sewa, 'credit' => 0],
            ['account' => '1100', 'debit' => 0, 'credit' => $sewa],
        ], $tx->id);

        // 4. Listrik & Air (tanggal 10)
        $listrik = rand(450000, 650000);
        $tx = Transaction::create([
            'tenant_id' => $this->tenantId,
            'user_id' => $this->userId,
            'category_id' => $this->categories['Listrik & Air'] ?? 7,
            'date' => sprintf('%d-%02d-10', $year, $month),
            'description' => 'Bayar listrik & air',
            'amount' => $listrik,
            'type' => 'expense',
            'is_taxable' => false,
        ]);

        $this->createJournal(sprintf('%d-%02d-10', $year, $month), 'Pembayaran listrik & air', [
            ['account' => '5400', 'debit' => $listrik, 'credit' => 0],
            ['account' => '1100', 'debit' => 0, 'credit' => $listrik],
        ], $tx->id);

        // 5. Transportasi/Pengiriman
        $transport = rand(300000, 600000);
        $tx = Transaction::create([
            'tenant_id' => $this->tenantId,
            'user_id' => $this->userId,
            'category_id' => $this->categories['Transportasi'] ?? 8,
            'date' => sprintf('%d-%02d-18', $year, $month),
            'description' => 'Biaya pengiriman & transportasi',
            'amount' => $transport,
            'type' => 'expense',
            'is_taxable' => false,
        ]);

        $this->createJournal(sprintf('%d-%02d-18', $year, $month), 'Biaya transportasi dan pengiriman', [
            ['account' => '5600', 'debit' => $transport, 'credit' => 0],
            ['account' => '1100', 'debit' => 0, 'credit' => $transport],
        ], $tx->id);

        // 6. Marketing (bulan tertentu)
        if (in_array($month, [10, 11, 12])) {
            $marketing = rand(500000, 1000000);
            $tx = Transaction::create([
                'tenant_id' => $this->tenantId,
                'user_id' => $this->userId,
                'category_id' => $this->categories['Marketing'] ?? 9,
                'date' => sprintf('%d-%02d-08', $year, $month),
                'description' => 'Iklan Instagram & Marketplace',
                'amount' => $marketing,
                'type' => 'expense',
                'is_taxable' => false,
            ]);

            $this->createJournal(sprintf('%d-%02d-08', $year, $month), 'Biaya marketing digital', [
                ['account' => '5900', 'debit' => $marketing, 'credit' => 0],
                ['account' => '1100', 'debit' => 0, 'credit' => $marketing],
            ], $tx->id);
        }
    }

    private function createJournal(string $date, string $description, array $lines, ?int $transactionId = null): void
    {
        $journal = JournalEntry::create([
            'tenant_id' => $this->tenantId,
            'user_id' => $this->userId,
            'transaction_id' => $transactionId,
            'entry_number' => sprintf('JE-2025-%04d', $this->journalSequence++),
            'date' => $date,
            'description' => $description,
            'is_posted' => true,
        ]);

        foreach ($lines as $line) {
            JournalLine::create([
                'journal_entry_id' => $journal->id,
                'account_id' => $this->accounts[$line['account']] ?? 1,
                'debit' => $line['debit'],
                'credit' => $line['credit'],
            ]);
        }
    }

    private function getMonthName(int $month): string
    {
        $names = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return $names[$month] ?? '';
    }
}
