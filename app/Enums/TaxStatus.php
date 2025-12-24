<?php

namespace App\Enums;

enum TaxStatus: string
{
    case EXEMPT = 'exempt';           // Omzet <= Rp500juta
    case PPH_FINAL = 'pph_final';     // Omzet Rp500juta - Rp4.8M
    case PKP = 'pkp';                 // Omzet > Rp4.8M

    public function label(): string
    {
        return match($this) {
            self::EXEMPT => 'Bebas PPh (PP 55/2022)',
            self::PPH_FINAL => 'PPh Final 0.5%',
            self::PKP => 'Pengusaha Kena Pajak (PKP)',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::EXEMPT => 'Omzet ≤ Rp500 juta/tahun, bebas PPh',
            self::PPH_FINAL => 'Omzet > Rp500 juta s.d. Rp4.8 miliar, PPh 0.5% dari omzet',
            self::PKP => 'Omzet > Rp4.8 miliar, wajib memungut PPN 11%',
        };
    }
}
