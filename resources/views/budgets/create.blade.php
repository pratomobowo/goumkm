<x-app-layout>
    <x-slot name="header">
        Tambah Anggaran
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('budgets.store') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Anggaran</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Target Penjualan"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="period_month" class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                            <select id="period_month" name="period_month" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $m)
                                    <option value="{{ $i+1 }}" {{ old('period_month', now()->month) == $i+1 ? 'selected' : '' }}>{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="period_year" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                            <select id="period_year" name="period_year" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                @for($y = now()->year; $y <= now()->year + 2; $y++)
                                    <option value="{{ $y }}" {{ old('period_year', now()->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="type" value="income" {{ old('type', 'expense') === 'income' ? 'checked' : '' }} class="text-blue-600">
                                <span class="text-sm text-gray-700">Pemasukan</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="type" value="expense" {{ old('type', 'expense') === 'expense' ? 'checked' : '' }} class="text-blue-600">
                                <span class="text-sm text-gray-700">Pengeluaran</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="planned_amount" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Anggaran (Rp)</label>
                        <input type="number" id="planned_amount" name="planned_amount" value="{{ old('planned_amount') }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        @error('planned_amount')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                        <textarea id="notes" name="notes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">Simpan</button>
                    <a href="{{ route('budgets.index') }}" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
