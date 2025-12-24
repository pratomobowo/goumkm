<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('reports.index');
    }

    public function incomeStatement(Request $request): View
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $tenantId = auth()->user()->tenant_id;

        // Get income by category
        $incomeData = Transaction::where('tenant_id', $tenantId)
            ->where('type', 'income')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->with('category')
            ->get()
            ->groupBy(fn($t) => $t->category?->name ?? 'Lainnya')
            ->map(fn($items) => $items->sum('amount'));

        // Get expense by category
        $expenseData = Transaction::where('tenant_id', $tenantId)
            ->where('type', 'expense')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->with('category')
            ->get()
            ->groupBy(fn($t) => $t->category?->name ?? 'Lainnya')
            ->map(fn($items) => $items->sum('amount'));

        $totalIncome = $incomeData->sum();
        $totalExpense = $expenseData->sum();
        $netProfit = $totalIncome - $totalExpense;

        return view('reports.income-statement', compact(
            'incomeData',
            'expenseData',
            'totalIncome',
            'totalExpense',
            'netProfit',
            'month',
            'year'
        ));
    }

    public function export(string $type)
    {
        // TODO: Implement PDF/Excel export
        return back()->with('info', 'Fitur export dalam pengembangan');
    }
}
