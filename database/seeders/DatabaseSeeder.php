<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@umkm-keuangan.id',
            'password' => bcrypt('password'),
            'role' => UserRole::SUPER_ADMIN,
            'is_super_admin' => true,
        ]);

        // Create sample tenant with owner
        $tenant = Tenant::create([
            'name' => 'Toko Sejahtera',
            'business_type' => 'Retail',
            'npwp' => '12.345.678.9-012.345',
            'address' => 'Jl. Contoh No. 123, Bandung',
            'phone' => '08123456789',
            'email' => 'toko@sejahtera.com',
            'has_inventory' => true,
            'tax_status' => 'exempt',
        ]);

        User::create([
            'name' => 'Pemilik Toko Sejahtera',
            'email' => 'owner@sejahtera.com',
            'password' => bcrypt('password'),
            'tenant_id' => $tenant->id,
            'role' => UserRole::OWNER,
        ]);

        // Seed categories
        $this->call(CategorySeeder::class);
        
        // Seed accounts (Chart of Accounts)
        $this->call(AccountSeeder::class);
        
        // Seed realistic demo data
        $this->call(RealisticDemoSeeder::class);
    }
}
