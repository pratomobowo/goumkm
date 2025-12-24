<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use App\Services\InventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockController extends Controller
{
    public function __construct(private InventoryService $service) {}

    public function index(): View
    {
        $movements = StockMovement::with(['product', 'user'])
            ->latest('date')
            ->paginate(20);

        $lowStockProducts = $this->service->getLowStockProducts(auth()->user()->tenant);

        return view('stock.index', compact('movements', 'lowStockProducts'));
    }

    public function createMovement(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'nullable|numeric|min:0',
            'reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['type'] === 'in') {
            $this->service->addStock($product, $validated['quantity'], $validated);
        } else {
            $this->service->reduceStock($product, $validated['quantity'], $validated);
        }

        return redirect()->route('stock.index')
            ->with('success', 'Pergerakan stok berhasil dicatat');
    }

    public function opname(): View
    {
        $products = Product::where('is_active', true)->orderBy('name')->get();

        return view('stock.opname', compact('products'));
    }
}
