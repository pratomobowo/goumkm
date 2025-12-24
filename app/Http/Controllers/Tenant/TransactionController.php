<?php

namespace App\Http\Controllers\Tenant;

use App\Enums\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(): View
    {
        $transactions = Transaction::with('category')
            ->latest('date')
            ->paginate(15);

        return view('transactions.index', compact('transactions'));
    }

    public function create(): View
    {
        $categories = Category::all()->groupBy('type');
        $types = TransactionType::cases();

        return view('transactions.create', compact('categories', 'types'));
    }

    public function store(StoreTransactionRequest $request): RedirectResponse
    {
        Transaction::create($request->validated() + [
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil disimpan');
    }

    public function show(Transaction $transaction): View
    {
        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction): View
    {
        $categories = Category::all()->groupBy('type');
        $types = TransactionType::cases();

        return view('transactions.edit', compact('transaction', 'categories', 'types'));
    }

    public function update(StoreTransactionRequest $request, Transaction $transaction): RedirectResponse
    {
        $transaction->update($request->validated());

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui');
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }
}
