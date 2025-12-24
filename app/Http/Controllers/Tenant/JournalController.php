<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalLine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class JournalController extends Controller
{
    public function index(Request $request): View
    {
        $journals = JournalEntry::with(['lines.account', 'user'])
            ->latest('date')
            ->paginate(15);

        return view('journal.index', compact('journals'));
    }

    public function create(): View
    {
        $accounts = Account::where('is_active', true)
            ->orderBy('code')
            ->get()
            ->groupBy('type');

        return view('journal.create', compact('accounts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'lines' => 'required|array|min:2',
            'lines.*.account_id' => 'required|exists:accounts,id',
            'lines.*.debit' => 'nullable|numeric|min:0',
            'lines.*.credit' => 'nullable|numeric|min:0',
            'lines.*.memo' => 'nullable|string|max:255',
        ]);

        // Validate balance
        $totalDebit = collect($validated['lines'])->sum('debit');
        $totalCredit = collect($validated['lines'])->sum('credit');

        if ($totalDebit != $totalCredit) {
            return back()->withInput()->withErrors([
                'balance' => 'Jurnal tidak seimbang. Debit: Rp ' . number_format($totalDebit) . ', Kredit: Rp ' . number_format($totalCredit)
            ]);
        }

        DB::transaction(function () use ($validated) {
            $journal = JournalEntry::create([
                'tenant_id' => auth()->user()->tenant_id,
                'user_id' => auth()->id(),
                'entry_number' => JournalEntry::generateEntryNumber(auth()->user()->tenant_id),
                'date' => $validated['date'],
                'description' => $validated['description'],
                'notes' => $validated['notes'] ?? null,
                'is_posted' => true,
            ]);

            foreach ($validated['lines'] as $line) {
                if (($line['debit'] ?? 0) > 0 || ($line['credit'] ?? 0) > 0) {
                    JournalLine::create([
                        'journal_entry_id' => $journal->id,
                        'account_id' => $line['account_id'],
                        'debit' => $line['debit'] ?? 0,
                        'credit' => $line['credit'] ?? 0,
                        'memo' => $line['memo'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('journal.index')
            ->with('success', 'Jurnal berhasil disimpan');
    }

    public function show(JournalEntry $journal): View
    {
        $journal->load(['lines.account', 'user']);

        return view('journal.show', compact('journal'));
    }

    public function destroy(JournalEntry $journal): RedirectResponse
    {
        $journal->delete();

        return redirect()->route('journal.index')
            ->with('success', 'Jurnal berhasil dihapus');
    }

    public function ledger(): View
    {
        $accounts = Account::where('is_active', true)
            ->orderBy('code')
            ->get()
            ->map(function ($account) {
                $account->balance = $account->getBalance();
                return $account;
            })
            ->groupBy('type');

        return view('journal.ledger', compact('accounts'));
    }
}
