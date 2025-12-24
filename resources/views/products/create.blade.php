<x-app-layout>
    <x-slot name="header">
        Tambah Produk
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU (Opsional)</label>
                            <input type="text" id="sku" name="sku" value="{{ old('sku') }}" placeholder="PRD001"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="unit" class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                            <select id="unit" name="unit" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="pcs">Pcs</option>
                                <option value="kg">Kg</option>
                                <option value="liter">Liter</option>
                                <option value="box">Box</option>
                                <option value="set">Set</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea id="description" name="description" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Beli (Rp)</label>
                            <input type="number" id="purchase_price" name="purchase_price" value="{{ old('purchase_price', 0) }}" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Jual (Rp)</label>
                            <input type="number" id="selling_price" name="selling_price" value="{{ old('selling_price', 0) }}" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="current_stock" class="block text-sm font-medium text-gray-700 mb-1">Stok Awal</label>
                            <input type="number" id="current_stock" name="current_stock" value="{{ old('current_stock', 0) }}" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="min_stock" class="block text-sm font-medium text-gray-700 mb-1">Stok Minimum</label>
                            <input type="number" id="min_stock" name="min_stock" value="{{ old('min_stock', 0) }}" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">Simpan Produk</button>
                    <a href="{{ route('products.index') }}" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
