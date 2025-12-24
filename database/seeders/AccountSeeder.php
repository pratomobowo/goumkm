<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = 1;

        $accounts = [
            // Aset (1xxx)
            ['code' => '1100', 'name' => 'Kas', 'type' => 'asset', 'normal_balance' => 'debit', 'is_system' => true],
            ['code' => '1110', 'name' => 'Bank', 'type' => 'asset', 'normal_balance' => 'debit', 'is_system' => true],
            ['code' => '1200', 'name' => 'Piutang Usaha', 'type' => 'asset', 'normal_balance' => 'debit', 'is_system' => true],
            ['code' => '1300', 'name' => 'Persediaan Barang', 'type' => 'asset', 'normal_balance' => 'debit', 'is_system' => true],
            ['code' => '1400', 'name' => 'Perlengkapan', 'type' => 'asset', 'normal_balance' => 'debit', 'is_system' => false],
            ['code' => '1500', 'name' => 'Peralatan', 'type' => 'asset', 'normal_balance' => 'debit', 'is_system' => false],

            // Kewajiban (2xxx)
            ['code' => '2100', 'name' => 'Utang Usaha', 'type' => 'liability', 'normal_balance' => 'credit', 'is_system' => true],
            ['code' => '2200', 'name' => 'Utang Pajak', 'type' => 'liability', 'normal_balance' => 'credit', 'is_system' => true],
            ['code' => '2300', 'name' => 'Pendapatan Diterima Dimuka', 'type' => 'liability', 'normal_balance' => 'credit', 'is_system' => false],

            // Modal (3xxx)
            ['code' => '3100', 'name' => 'Modal Pemilik', 'type' => 'equity', 'normal_balance' => 'credit', 'is_system' => true],
            ['code' => '3200', 'name' => 'Prive', 'type' => 'equity', 'normal_balance' => 'debit', 'is_system' => false],
            ['code' => '3300', 'name' => 'Laba Ditahan', 'type' => 'equity', 'normal_balance' => 'credit', 'is_system' => true],

            // Pendapatan (4xxx)
            ['code' => '4100', 'name' => 'Penjualan', 'type' => 'income', 'normal_balance' => 'credit', 'is_system' => true],
            ['code' => '4200', 'name' => 'Pendapatan Jasa', 'type' => 'income', 'normal_balance' => 'credit', 'is_system' => true],
            ['code' => '4300', 'name' => 'Pendapatan Lain-lain', 'type' => 'income', 'normal_balance' => 'credit', 'is_system' => false],
            ['code' => '4400', 'name' => 'Potongan Penjualan', 'type' => 'income', 'normal_balance' => 'debit', 'is_system' => false],

            // Beban (5xxx)
            ['code' => '5100', 'name' => 'Harga Pokok Penjualan', 'type' => 'expense', 'normal_balance' => 'debit', 'is_system' => true],
            ['code' => '5200', 'name' => 'Beban Gaji', 'type' => 'expense', 'normal_balance' => 'debit', 'is_system' => true],
            ['code' => '5300', 'name' => 'Beban Sewa', 'type' => 'expense', 'normal_balance' => 'debit', 'is_system' => true],
            ['code' => '5400', 'name' => 'Beban Listrik & Air', 'type' => 'expense', 'normal_balance' => 'debit', 'is_system' => true],
            ['code' => '5500', 'name' => 'Beban Telepon & Internet', 'type' => 'expense', 'normal_balance' => 'debit', 'is_system' => false],
            ['code' => '5600', 'name' => 'Beban Transportasi', 'type' => 'expense', 'normal_balance' => 'debit', 'is_system' => false],
            ['code' => '5700', 'name' => 'Beban Perlengkapan', 'type' => 'expense', 'normal_balance' => 'debit', 'is_system' => false],
            ['code' => '5800', 'name' => 'Beban Penyusutan', 'type' => 'expense', 'normal_balance' => 'debit', 'is_system' => false],
            ['code' => '5900', 'name' => 'Beban Lain-lain', 'type' => 'expense', 'normal_balance' => 'debit', 'is_system' => false],
        ];

        foreach ($accounts as $account) {
            Account::create(array_merge($account, ['tenant_id' => $tenantId]));
        }
    }
}
