<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BudgetController extends Controller
{
    public function index(): View
    {
        $budgets = Budget::with('category')
            ->orderBy('period_year', 'desc')
            ->orderBy('period_month', 'desc')
            ->paginate(15);

        return view('budgets.index', compact('budgets'));
    }

    public function create(): View
    {
        return view('budgets.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'category_id' => 'nullable|exists:categories,id',
            'period_month' => 'required|integer|min:1|max:12',
            'period_year' => 'required|integer|min:2020|max:2100',
            'planned_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        Budget::create($validated);

        return redirect()->route('budgets.index')
            ->with('success', 'Anggaran berhasil dibuat');
    }

    public function show(Budget $budget): View
    {
        return view('budgets.show', compact('budget'));
    }

    public function edit(Budget $budget): View
    {
        return view('budgets.edit', compact('budget'));
    }

    public function update(Request $request, Budget $budget): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'category_id' => 'nullable|exists:categories,id',
            'planned_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $budget->update($validated);

        return redirect()->route('budgets.index')
            ->with('success', 'Anggaran berhasil diperbarui');
    }

    public function destroy(Budget $budget): RedirectResponse
    {
        $budget->delete();

        return redirect()->route('budgets.index')
            ->with('success', 'Anggaran berhasil dihapus');
    }
}
