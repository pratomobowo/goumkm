<x-app-layout>
    <x-slot name="header">
        Detail Produk
    </x-slot>

    <div class="max-w-2xl space-y-6">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ $product->name }}</h2>
                    <p class="text-sm text-gray-500">SKU: {{ $product->sku ?? '-' }}</p>
                </div>
                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $product->isLowStock() ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                    {{ $product->current_stock }} {{ $product->unit }}
                </span>
            </div>

            <dl class="space-y-4">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm text-gray-500">Harga Beli</dt>
                    <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm text-gray-500">Harga Jual</dt>
                    <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm text-gray-500">Margin</dt>
                    <dd class="text-sm font-medium text-green-600">Rp {{ number_format($product->margin, 0, ',', '.') }} ({{ number_format($product->margin_percentage, 1) }}%)</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm text-gray-500">Stok Minimum</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $product->min_stock }} {{ $product->unit }}</dd>
                </div>
                @if($product->description)
                <div class="py-2">
                    <dt class="text-sm text-gray-500 mb-1">Deskripsi</dt>
                    <dd class="text-sm text-gray-700">{{ $product->description }}</dd>
                </div>
                @endif
            </dl>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('products.edit', $product) }}" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">Edit</a>
            <a href="{{ route('products.index') }}" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">Kembali</a>
        </div>
    </div>
</x-app-layout>
