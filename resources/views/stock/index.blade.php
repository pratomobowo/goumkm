<x-app-layout>
    <x-slot name="header">
        Stok
    </x-slot>

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Pergerakan Stok</h2>
                <p class="text-sm text-gray-500">Catat stok masuk dan keluar</p>
            </div>
            <a href="{{ route('stock.opname') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                Stock Opname
            </a>
        </div>

        @if($lowStockProducts->count() > 0)
        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
            <p class="text-sm font-medium text-yellow-800">⚠️ {{ $lowStockProducts->count() }} produk dengan stok menipis</p>
        </div>
        @endif

        @if(session('success'))
            <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dicatat Oleh</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($movements as $movement)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $movement->date->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $movement->product->name }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $movement->type->isAddition() ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $movement->type->label() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-right font-medium">{{ $movement->quantity }} {{ $movement->product->unit }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $movement->user->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada pergerakan stok</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($movements->hasPages())
                <div class="px-4 py-3 border-t border-gray-200">{{ $movements->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
