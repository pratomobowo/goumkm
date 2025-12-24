<x-app-layout>
    <x-slot name="header">
        Edit Transaksi
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('transactions.update', $transaction) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Type Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Tipe Transaksi</label>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($types as $type)
                            <label class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all
                                          {{ $type->value === 'income' ? 'border-green-500 bg-green-50' : 'border-red-500 bg-red-50' }}">
                                <input type="radio" name="type" value="{{ $type->value }}" class="sr-only" {{ $transaction->type->value === $type->value ? 'checked' : '' }}>
                                <div class="text-center">
                                    <svg class="w-6 h-6 mx-auto mb-1 {{ $type->value === 'income' ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $type->value === 'income' ? 'M7 11l5-5m0 0l5 5m-5-5v12' : 'M17 13l-5 5m0 0l-5-5m5 5V6' }}"/>
                                    </svg>
                                    <span class="text-sm font-medium {{ $type->value === 'income' ? 'text-green-700' : 'text-red-700' }}">{{ $type->label() }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Date -->
                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" id="date" name="date" value="{{ old('date', $transaction->date->format('Y-m-d')) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <input type="text" id="description" name="description" value="{{ old('description', $transaction->description) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Amount -->
                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Rp)</label>
                    <input type="number" id="amount" name="amount" value="{{ old('amount', $transaction->amount) }}" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select id="category_id" name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="">Pilih kategori</option>
                        @if(isset($categories['income']))
                            <optgroup label="Pemasukan">
                                @foreach($categories['income'] as $cat)
                                    <option value="{{ $cat->id }}" {{ $transaction->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(isset($categories['expense']))
                            <optgroup label="Pengeluaran">
                                @foreach($categories['expense'] as $cat)
                                    <option value="{{ $cat->id }}" {{ $transaction->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </optgroup>
                        @endif
                    </select>
                </div>

                <!-- Is Taxable -->
                <div class="mb-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_taxable" value="1" {{ $transaction->is_taxable ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                        <span class="text-sm text-gray-700">Termasuk perhitungan pajak</span>
                    </label>
                </div>

                <!-- Notes -->
                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <textarea id="notes" name="notes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg">{{ old('notes', $transaction->notes) }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">Simpan Perubahan</button>
                    <a href="{{ route('transactions.index') }}" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
