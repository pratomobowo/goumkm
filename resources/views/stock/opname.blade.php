<x-app-layout>
    <x-slot name="header">
        Stock Opname
    </x-slot>

    <div class="space-y-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Stock Opname</h2>
            <p class="text-sm text-gray-500">Sesuaikan stok fisik dengan stok sistem</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Stok Sistem</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Stok Fisik</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Selisih</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->sku }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm text-right">{{ $product->current_stock }} {{ $product->unit }}</td>
                            <td class="px-4 py-3">
                                <input type="number" name="physical_stock[{{ $product->id }}]" 
                                       value="{{ $product->current_stock }}" min="0"
                                       class="w-24 px-2 py-1 text-right border border-gray-300 rounded text-sm">
                            </td>
                            <td class="px-4 py-3 text-sm text-right">-</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex gap-3">
            <button type="button" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">
                Proses Opname
            </button>
            <a href="{{ route('stock.index') }}" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">Kembali</a>
        </div>
    </div>
</x-app-layout>
