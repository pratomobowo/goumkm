<?php

namespace App\Enums;

enum UserRole: string
{
    case SUPER_ADMIN = 'super_admin';
    case OWNER = 'owner';
    case STAFF = 'staff';
    case ACCOUNTANT = 'accountant';

    public function label(): string
    {
        return match($this) {
            self::SUPER_ADMIN => 'Super Admin',
            self::OWNER => 'Pemilik Usaha',
            self::STAFF => 'Staff',
            self::ACCOUNTANT => 'Akuntan',
        };
    }

    public function permissions(): array
    {
        return match($this) {
            self::SUPER_ADMIN => ['*'],
            self::OWNER => ['tenant.*', 'transaction.*', 'budget.*', 'inventory.*', 'report.*', 'tax.*'],
            self::STAFF => ['transaction.create', 'transaction.view', 'inventory.view', 'inventory.create'],
            self::ACCOUNTANT => ['transaction.view', 'budget.*', 'report.*', 'tax.*'],
        };
    }
}
