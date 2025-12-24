<x-app-layout>
    <x-slot name="header">
        Produk
    </x-slot>

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Daftar Produk</h2>
                <p class="text-sm text-gray-500">Kelola produk dan stok usaha Anda</p>
            </div>
            <a href="{{ route('products.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Produk
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Produk</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga Beli</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga Jual</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Stok</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $product->sku ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $product->name }}</td>
                            <td class="px-4 py-3 text-sm text-right">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm text-right">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $product->isLowStock() ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                    {{ $product->current_stock }} {{ $product->unit }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:text-blue-700 text-sm">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada produk</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($products->hasPages())
                <div class="px-4 py-3 border-t border-gray-200">{{ $products->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
