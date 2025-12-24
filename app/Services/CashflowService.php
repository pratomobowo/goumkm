<?php

namespace App\Services;

use App\Models\Tenant;
use App\Models\Transaction;

class CashflowService
{
    public function generateCashflow(Tenant $tenant, int $month, int $year): array
    {
        $income = $this->getTotalIncome($tenant, $month, $year);
        $expense = $this->getTotalExpense($tenant, $month, $year);
        $netCashflow = $income - $expense;

        return [
            'period_month' => $month,
            'period_year' => $year,
            'total_income' => $income,
            'total_expense' => $expense,
            'net_cashflow' => $netCashflow,
            'is_positive' => $netCashflow >= 0,
            'income_breakdown' => $this->getIncomeByCategory($tenant, $month, $year),
            'expense_breakdown' => $this->getExpenseByCategory($tenant, $month, $year),
        ];
    }

    public function getCashflowTrend(Tenant $tenant, int $months = 6): array
    {
        $trend = [];
        $currentDate = now();

        for ($i = $months - 1; $i >= 0; $i--) {
            $date = $currentDate->copy()->subMonths($i);
            $month = $date->month;
            $year = $date->year;

            $income = $this->getTotalIncome($tenant, $month, $year);
            $expense = $this->getTotalExpense($tenant, $month, $year);

            $trend[] = [
                'month' => $date->format('M Y'),
                'income' => $income,
                'expense' => $expense,
                'net' => $income - $expense,
            ];
        }

        return $trend;
    }

    private function getTotalIncome(Tenant $tenant, int $month, int $year): float
    {
        return Transaction::where('tenant_id', $tenant->id)
            ->where('type', 'income')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('amount');
    }

    private function getTotalExpense(Tenant $tenant, int $month, int $year): float
    {
        return Transaction::where('tenant_id', $tenant->id)
            ->where('type', 'expense')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('amount');
    }

    private function getIncomeByCategory(Tenant $tenant, int $month, int $year): array
    {
        return Transaction::where('tenant_id', $tenant->id)
            ->where('type', 'income')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->with('category')
            ->get()
            ->groupBy('category_id')
            ->map(fn($items) => [
                'category' => $items->first()->category?->name ?? 'Tanpa Kategori',
                'total' => $items->sum('amount'),
            ])
            ->values()
            ->toArray();
    }

    private function getExpenseByCategory(Tenant $tenant, int $month, int $year): array
    {
        return Transaction::where('tenant_id', $tenant->id)
            ->where('type', 'expense')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->with('category')
            ->get()
            ->groupBy('category_id')
            ->map(fn($items) => [
                'category' => $items->first()->category?->name ?? 'Tanpa Kategori',
                'total' => $items->sum('amount'),
            ])
            ->values()
            ->toArray();
    }
}
