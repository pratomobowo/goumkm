<?php

namespace App\Services;

use App\Enums\StockMovementType;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Tenant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    public function addStock(Product $product, int $qty, array $data = []): StockMovement
    {
        return DB::transaction(function () use ($product, $qty, $data) {
            $movement = StockMovement::create([
                'tenant_id' => $product->tenant_id,
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'type' => StockMovementType::IN,
                'quantity' => $qty,
                'unit_price' => $data['unit_price'] ?? $product->purchase_price,
                'total_price' => $qty * ($data['unit_price'] ?? $product->purchase_price),
                'reference' => $data['reference'] ?? null,
                'notes' => $data['notes'] ?? null,
                'date' => $data['date'] ?? now(),
            ]);

            $product->increment('current_stock', $qty);

            return $movement;
        });
    }

    public function reduceStock(Product $product, int $qty, array $data = []): StockMovement
    {
        return DB::transaction(function () use ($product, $qty, $data) {
            $movement = StockMovement::create([
                'tenant_id' => $product->tenant_id,
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'type' => StockMovementType::OUT,
                'quantity' => $qty,
                'unit_price' => $data['unit_price'] ?? $product->selling_price,
                'total_price' => $qty * ($data['unit_price'] ?? $product->selling_price),
                'reference' => $data['reference'] ?? null,
                'notes' => $data['notes'] ?? null,
                'date' => $data['date'] ?? now(),
            ]);

            $product->decrement('current_stock', $qty);

            return $movement;
        });
    }

    public function adjustStock(Product $product, int $newQty, string $reason = ''): StockMovement
    {
        return DB::transaction(function () use ($product, $newQty, $reason) {
            $difference = $newQty - $product->current_stock;

            $movement = StockMovement::create([
                'tenant_id' => $product->tenant_id,
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'type' => StockMovementType::ADJUSTMENT,
                'quantity' => $difference,
                'unit_price' => 0,
                'total_price' => 0,
                'notes' => $reason,
                'date' => now(),
            ]);

            $product->update(['current_stock' => $newQty]);

            return $movement;
        });
    }

    public function getLowStockProducts(Tenant $tenant): Collection
    {
        return Product::where('tenant_id', $tenant->id)
            ->where('is_active', true)
            ->whereColumn('current_stock', '<=', 'min_stock')
            ->get();
    }

    public function calculateHPP(Product $product, int $month, int $year): float
    {
        $soldQty = StockMovement::where('product_id', $product->id)
            ->where('type', StockMovementType::OUT)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('quantity');

        return $soldQty * $product->purchase_price;
    }
}
