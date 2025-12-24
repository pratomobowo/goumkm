<x-app-layout>
    <x-slot name="header">
        Pengaturan
    </x-slot>

    <div class="max-w-2xl">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Informasi Usaha</h2>

            @if($tenant)
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Usaha</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $tenant->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="business_type" class="block text-sm font-medium text-gray-700 mb-1">Jenis Usaha</label>
                        <select id="business_type" name="business_type" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih jenis usaha</option>
                            <option value="Kuliner" {{ $tenant->business_type === 'Kuliner' ? 'selected' : '' }}>Kuliner</option>
                            <option value="Retail" {{ $tenant->business_type === 'Retail' ? 'selected' : '' }}>Retail</option>
                            <option value="Jasa" {{ $tenant->business_type === 'Jasa' ? 'selected' : '' }}>Jasa</option>
                            <option value="Produksi" {{ $tenant->business_type === 'Produksi' ? 'selected' : '' }}>Produksi</option>
                            <option value="Lainnya" {{ $tenant->business_type === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label for="npwp" class="block text-sm font-medium text-gray-700 mb-1">NPWP</label>
                        <input type="text" id="npwp" name="npwp" value="{{ old('npwp', $tenant->npwp) }}" placeholder="XX.XXX.XXX.X-XXX.XXX"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $tenant->phone) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Usaha</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $tenant->email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea id="address" name="address" rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('address', $tenant->address) }}</textarea>
                    </div>

                    <div>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="has_inventory" value="1" {{ $tenant->has_inventory ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Aktifkan modul Inventori/Stok</span>
                        </label>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
            @else
                <p class="text-gray-500">Anda belum memiliki usaha terdaftar.</p>
            @endif
        </div>
    </div>
</x-app-layout>
