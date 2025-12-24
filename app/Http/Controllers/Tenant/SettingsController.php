<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $tenant = auth()->user()->tenant;

        return view('settings.index', compact('tenant'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'business_type' => 'nullable|string|max:100',
            'npwp' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'has_inventory' => 'boolean',
        ]);

        auth()->user()->tenant?->update($validated);

        return back()->with('success', 'Pengaturan berhasil disimpan');
    }
}
