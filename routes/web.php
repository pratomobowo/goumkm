<?php

use App\Http\Controllers\Tenant\BudgetController;
use App\Http\Controllers\Tenant\CashflowController;
use App\Http\Controllers\Tenant\CategoryController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\JournalController;
use App\Http\Controllers\Tenant\ProductController;
use App\Http\Controllers\Tenant\ReportController;
use App\Http\Controllers\Tenant\SettingsController;
use App\Http\Controllers\Tenant\StockController;
use App\Http\Controllers\Tenant\TaxController;
use App\Http\Controllers\Tenant\TransactionController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::view('/', 'welcome')->name('home');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::view('profile', 'profile')->name('profile');

    // Transactions
    Route::resource('transactions', TransactionController::class);

    // Categories
    Route::resource('categories', CategoryController::class);

    // Budgets
    Route::resource('budgets', BudgetController::class);

    // Cashflow
    Route::get('cashflow', [CashflowController::class, 'index'])->name('cashflow.index');

    // Products & Stock (Inventory)
    Route::resource('products', ProductController::class);
    Route::get('stock', [StockController::class, 'index'])->name('stock.index');
    Route::post('stock/movement', [StockController::class, 'createMovement'])->name('stock.movement');
    Route::get('stock/opname', [StockController::class, 'opname'])->name('stock.opname');

    // Tax
    Route::get('tax', [TaxController::class, 'index'])->name('tax.index');
    Route::get('tax/calculate/{year}', [TaxController::class, 'calculate'])->name('tax.calculate');

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/income-statement', [ReportController::class, 'incomeStatement'])->name('reports.income-statement');
    Route::get('reports/export/{type}', [ReportController::class, 'export'])->name('reports.export');

    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');

    // Journal
    Route::get('journal', [JournalController::class, 'index'])->name('journal.index');
    Route::get('journal/create', [JournalController::class, 'create'])->name('journal.create');
    Route::post('journal', [JournalController::class, 'store'])->name('journal.store');
    Route::get('journal/{journal}', [JournalController::class, 'show'])->name('journal.show');
    Route::delete('journal/{journal}', [JournalController::class, 'destroy'])->name('journal.destroy');
    Route::get('ledger', [JournalController::class, 'ledger'])->name('journal.ledger');
});

require __DIR__.'/auth.php';
