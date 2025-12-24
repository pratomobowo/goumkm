<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Services\CashflowService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CashflowController extends Controller
{
    public function __construct(private CashflowService $service) {}

    public function index(Request $request): View
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $tenant = auth()->user()->tenant;

        $cashflow = $tenant 
            ? $this->service->generateCashflow($tenant, $month, $year)
            : null;

        $trend = $tenant 
            ? $this->service->getCashflowTrend($tenant, 12)
            : [];

        return view('cashflow.index', compact('cashflow', 'trend', 'month', 'year'));
    }
}
