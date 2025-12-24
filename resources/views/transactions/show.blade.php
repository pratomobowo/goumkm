<x-app-layout>
    <x-slot name="header">
        Detail Transaksi
    </x-slot>

    <div class="max-w-2xl space-y-6">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center {{ $transaction->isIncome() ? 'bg-green-100' : 'bg-red-100' }}">
                        <svg class="w-6 h-6 {{ $transaction->isIncome() ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $transaction->isIncome() ? 'M7 11l5-5m0 0l5 5m-5-5v12' : 'M17 13l-5 5m0 0l-5-5m5 5V6' }}"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">{{ $transaction->description }}</h2>
                        <p class="text-sm text-gray-500">{{ $transaction->date->format('d F Y') }}</p>
                    </div>
                </div>
                <p class="text-2xl font-bold {{ $transaction->isIncome() ? 'text-green-600' : 'text-red-600' }}">
                    {{ $transaction->isIncome() ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                </p>
            </div>

            <dl class="space-y-3">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm text-gray-500">Tipe</dt>
                    <dd><span class="px-2 py-1 text-xs font-medium rounded-full {{ $transaction->isIncome() ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $transaction->type->label() }}</span></dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm text-gray-500">Kategori</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $transaction->category?->name ?? 'Tanpa Kategori' }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm text-gray-500">Kena Pajak</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $transaction->is_taxable ? 'Ya' : 'Tidak' }}</dd>
                </div>
                @if($transaction->notes)
                <div class="py-2">
                    <dt class="text-sm text-gray-500 mb-1">Catatan</dt>
                    <dd class="text-sm text-gray-700">{{ $transaction->notes }}</dd>
                </div>
                @endif
            </dl>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('transactions.edit', $transaction) }}" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">Edit</a>
            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-red-600 font-medium rounded-lg hover:bg-red-50">Hapus</button>
            </form>
            <a href="{{ route('transactions.index') }}" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">Kembali</a>
        </div>
    </div>
</x-app-layout>
