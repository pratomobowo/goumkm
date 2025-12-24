<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\TaxRecord;
use App\Services\TaxCalculatorService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaxController extends Controller
{
    public function __construct(private TaxCalculatorService $service) {}

    public function index(): View
    {
        $tenant = auth()->user()->tenant;
        $currentYear = now()->year;

        $annualTax = $tenant 
            ? $this->service->calculateAnnualTax($tenant, $currentYear)
            : null;

        $taxRecords = TaxRecord::where('period_year', $currentYear)
            ->orderBy('period_month')
            ->get();

        return view('tax.index', compact('annualTax', 'taxRecords', 'currentYear'));
    }

    public function calculate(int $year): View
    {
        $tenant = auth()->user()->tenant;

        $monthlyTaxes = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyTaxes[] = $this->service->calculateMonthlyTax($tenant, $month, $year);
        }

        $annualTax = $this->service->calculateAnnualTax($tenant, $year);

        return view('tax.calculate', compact('monthlyTaxes', 'annualTax', 'year'));
    }
}
