<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\Product;
use App\Models\Transaction;
use App\Services\CashflowService;
use App\Services\TaxCalculatorService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private CashflowService $cashflowService,
        private TaxCalculatorService $taxService
    ) {}

    public function index(): View
    {
        $tenant = auth()->user()->tenant;
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Get cashflow data
        $cashflow = $tenant 
            ? $this->cashflowService->generateCashflow($tenant, $currentMonth, $currentYear)
            : null;

        // Get tax estimate
        $taxEstimate = $tenant 
            ? $this->taxService->calculateMonthlyTax($tenant, $currentMonth, $currentYear)
            : null;

        // Get recent transactions
        $recentTransactions = Transaction::with('category')
            ->latest('date')
            ->take(5)
            ->get();

        // Get budget summary
        $budgetSummary = Budget::where('period_month', $currentMonth)
            ->where('period_year', $currentYear)
            ->get()
            ->map(fn($b) => [
                'name' => $b->name,
                'planned' => $b->planned_amount,
                'realized' => $b->realization,
                'percentage' => $b->percentage,
            ]);

        // Get low stock products
        $lowStockProducts = $tenant?->has_inventory 
            ? Product::where('is_active', true)
                ->whereColumn('current_stock', '<=', 'min_stock')
                ->take(5)
                ->get()
            : collect();

        // Get cashflow trend
        $cashflowTrend = $tenant 
            ? $this->cashflowService->getCashflowTrend($tenant, 6)
            : [];

        return view('dashboard', compact(
            'cashflow',
            'taxEstimate',
            'recentTransactions',
            'budgetSummary',
            'lowStockProducts',
            'cashflowTrend'
        ));
    }
}
