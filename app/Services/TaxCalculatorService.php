<?php

namespace App\Services;

use App\Enums\TaxStatus;
use App\Models\Tenant;
use App\Models\Transaction;

class TaxCalculatorService
{
    // PP 55/2022 thresholds
    public const EXEMPT_THRESHOLD = 500_000_000;      // Rp 500 juta
    public const PPH_FINAL_THRESHOLD = 4_800_000_000; // Rp 4.8 miliar
    public const PPH_FINAL_RATE = 0.005;              // 0.5%
    public const PPN_RATE = 0.11;                     // 11%

    public function calculateMonthlyTax(Tenant $tenant, int $month, int $year): array
    {
        $revenue = $this->getMonthlyRevenue($tenant, $month, $year);
        $annualRevenue = $this->getYearToDateRevenue($tenant, $year);
        $status = $this->determineStatus($annualRevenue);

        return [
            'period_month' => $month,
            'period_year' => $year,
            'gross_revenue' => $revenue,
            'annual_revenue_ytd' => $annualRevenue,
            'tax_status' => $status,
            'tax_amount' => $this->calculateTaxAmount($revenue, $status),
            'tax_rate' => $this->getTaxRate($status),
        ];
    }

    public function calculateAnnualTax(Tenant $tenant, int $year): array
    {
        $totalRevenue = $this->getAnnualRevenue($tenant, $year);
        $status = $this->determineStatus($totalRevenue);

        return [
            'period_year' => $year,
            'gross_revenue' => $totalRevenue,
            'tax_status' => $status,
            'tax_amount' => $this->calculateTaxAmount($totalRevenue, $status),
            'tax_rate' => $this->getTaxRate($status),
        ];
    }

    public function determineStatus(float $annualRevenue): TaxStatus
    {
        if ($annualRevenue <= self::EXEMPT_THRESHOLD) {
            return TaxStatus::EXEMPT;
        }

        if ($annualRevenue <= self::PPH_FINAL_THRESHOLD) {
            return TaxStatus::PPH_FINAL;
        }

        return TaxStatus::PKP;
    }

    private function calculateTaxAmount(float $revenue, TaxStatus $status): float
    {
        return match($status) {
            TaxStatus::EXEMPT => 0,
            TaxStatus::PPH_FINAL => $revenue * self::PPH_FINAL_RATE,
            TaxStatus::PKP => $revenue * self::PPN_RATE,
        };
    }

    private function getTaxRate(TaxStatus $status): float
    {
        return match($status) {
            TaxStatus::EXEMPT => 0,
            TaxStatus::PPH_FINAL => self::PPH_FINAL_RATE,
            TaxStatus::PKP => self::PPN_RATE,
        };
    }

    private function getMonthlyRevenue(Tenant $tenant, int $month, int $year): float
    {
        return Transaction::where('tenant_id', $tenant->id)
            ->where('type', 'income')
            ->where('is_taxable', true)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('amount');
    }

    private function getAnnualRevenue(Tenant $tenant, int $year): float
    {
        return Transaction::where('tenant_id', $tenant->id)
            ->where('type', 'income')
            ->where('is_taxable', true)
            ->whereYear('date', $year)
            ->sum('amount');
    }

    private function getYearToDateRevenue(Tenant $tenant, int $year): float
    {
        return $this->getAnnualRevenue($tenant, $year);
    }
}
